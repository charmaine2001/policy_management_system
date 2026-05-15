<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Query;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_policies' => Policy::count(),
            'active_policies' => Policy::where('status', 'Active')->count(),
            'expired_policies' => Policy::where('status', 'Expired')->count(),
            'pending_queries' => Query::where('status', 'Open')->count(),
            'resolved_queries' => Query::where('status', 'Resolved')->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
