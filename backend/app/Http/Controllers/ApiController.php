<?php

namespace App\Http\Controllers;

use App\Models\Policy;
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

    public function policies(Request $request)
    {
        return $request->user()->policies()->latest()->get();
    }

    public function policyDetails(Policy $policy)
    {
        if (auth()->id() !== $policy->client_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        return $policy->load('documents');
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
