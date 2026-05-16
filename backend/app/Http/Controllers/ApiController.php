<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\PolicyType;
use App\Models\Query;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
}
