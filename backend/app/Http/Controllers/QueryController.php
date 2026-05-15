<?php

namespace App\Http\Controllers;

use App\Models\Query;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function index()
    {
        $queries = Query::with('client')->latest()->paginate(10);
        return view('queries.index', compact('queries'));
    }

    public function show(Query $query)
    {
        $query->load('client');
        return view('queries.show', compact('query'));
    }

    public function update(Request $request, Query $query)
    {
        $request->validate([
            'response' => 'required',
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);

        $query->update([
            'response' => $request->response,
            'status' => $request->status,
        ]);

        return redirect()->route('queries.index')->with('success', 'Query updated successfully.');
    }
}
