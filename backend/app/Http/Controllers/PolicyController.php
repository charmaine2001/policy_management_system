<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\User;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function index()
    {
        $policies = Policy::with('client')->latest()->paginate(10);
        return view('policies.index', compact('policies'));
    }

    public function create()
    {
        $clients = User::where('role', 'client')->get();
        return view('policies.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'policy_number' => 'required|unique:policies',
            'client_id' => 'required|exists:users,id',
            'insurance_type' => 'required',
            'premium_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'renewal_date' => 'required|date|after:start_date',
            'status' => 'required|in:Active,Expired,Pending Renewal',
        ]);

        Policy::create($request->all());

        return redirect()->route('policies.index')->with('success', 'Policy created successfully.');
    }

    public function show(Policy $policy)
    {
        $policy->load('client', 'documents');
        return view('policies.show', compact('policy'));
    }

    public function edit(Policy $policy)
    {
        $clients = User::where('role', 'client')->get();
        return view('policies.edit', compact('policy', 'clients'));
    }

    public function update(Request $request, Policy $policy)
    {
        $request->validate([
            'policy_number' => 'required|unique:policies,policy_number,' . $policy->id,
            'client_id' => 'required|exists:users,id',
            'insurance_type' => 'required',
            'premium_amount' => 'required|numeric',
            'start_date' => 'required|date',
            'renewal_date' => 'required|date|after:start_date',
            'status' => 'required|in:Active,Expired,Pending Renewal',
        ]);

        $policy->update($request->all());

        return redirect()->route('policies.index')->with('success', 'Policy updated successfully.');
    }

    public function destroy(Policy $policy)
    {
        $policy->delete();
        return redirect()->route('policies.index')->with('success', 'Policy deleted successfully.');
    }
}
