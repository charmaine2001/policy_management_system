<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Policy;
use App\Models\PolicyType;
use App\Models\Query;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if ($user->role !== 'client') {
            return response()->json(['message' => 'Unauthorized. Only clients can access the mobile app.'], 403);
        }

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'device_name' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
        ]);

        return response()->json([
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => $user
        ], 201);
    }

    public function policies(Request $request)
    {
        return $request->user()->policies()->with('type')->latest()->get();
    }

    public function policyDetails(Policy $policy)
    {
        if (auth()->id() !== $policy->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $policy->load(['documents', 'type']);
    }

    public function getPolicyTypes()
    {
        return PolicyType::all();
    }

    public function addPolicy(Request $request)
    {
        $request->validate([
            'policy_type_id' => 'required|exists:policy_types,id',
            'plan_type' => 'required|in:Standard,Premium',
            'start_date' => 'required|date',
        ]);

        $policyType = PolicyType::find($request->policy_type_id);
        
        $price = $request->plan_type === 'Standard' 
            ? $policyType->standard_price 
            : $policyType->premium_price;

        $startDate = \Carbon\Carbon::parse($request->start_date);
        $renewalDate = $startDate->copy()->addYear();

        $policyNumber = 'ZIM-POL-' . strtoupper(bin2hex(random_bytes(3)));

        $policy = Policy::create([
            'policy_number' => $policyNumber,
            'user_id' => $request->user()->id,
            'policy_type_id' => $request->policy_type_id,
            'plan_type' => $request->plan_type,
            'final_price' => $price,
            'start_date' => $startDate,
            'renewal_date' => $renewalDate,
            'status' => 'Active',
        ]);

        return response()->json($policy->load('type'), 201);
    }

    public function raiseQuery(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);

        $query = Query::create([
            'client_id' => $request->user()->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'Open',
        ]);

        return response()->json($query, 201);
    }

    public function queries(Request $request)
    {
        return $request->user()->queries()->latest()->get();
    }

    /**
     * Upload a document to a policy
     * 
     * This method handles file uploads from mobile and web clients.
     * It validates the file, stores it, and creates a database record.
     * 
     * @param Request $request - Contains the file and policy ID
     * @param Policy $policy - The policy to attach the document to
     * @return \Illuminate\Http\JsonResponse - Success or error response
     */
    public function uploadDocument(Request $request, Policy $policy)
    {
        // Authorization check - only policy owner can upload documents
        if (auth()->id() !== $policy->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate the incoming file
        $request->validate([
            'file' => 'required|file|max:2048|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ], [
            'file.required' => 'Please upload a file',
            'file.max' => 'File must not exceed 2MB',
            'file.mimes' => 'Only PDF, images (JPG, PNG), and documents (DOC, DOCX, XLS, XLSX) are allowed',
        ]);

        try {
            $file = $request->file('file');
            
            // Create a unique filename: policy_id_timestamp_originalname
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
            $filePath = "documents/{$policy->id}/" . time() . "_" . $fileName;
            
            // Store file in storage/app/public (accessible via /storage URL)
            Storage::disk('public')->put($filePath, file_get_contents($file));
            
            // Create database record for the document
            $document = Document::create([
                'policy_id' => $policy->id,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_type' => $fileType,
            ]);
            
            return response()->json([
                'message' => 'Document uploaded successfully',
                'document' => $document,
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to upload document',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
