<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Incident;
use App\Models\IncidentComment;
use App\Models\IncidentVerification;
use App\Models\UserAlert;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'verified_users' => User::where('is_verified', true)->count(),
            'total_incidents' => Incident::count(),
            'verified_incidents' => Incident::where('is_verified', true)->count(),
            'pending_incidents' => Incident::where('status', 'pending')->count(),
            'resolved_incidents' => Incident::where('status', 'resolved')->count(),
            'total_comments' => IncidentComment::count(),
            'total_verifications' => IncidentVerification::count(),
            'total_alerts' => UserAlert::count(),
        ];

        $recentIncidents = Incident::with('user')
            ->latest()
            ->limit(5)
            ->get();

        $recentUsers = User::latest()
            ->limit(5)
            ->get();

        $incidentsByCategory = Incident::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->get();

        $incidentsByStatus = Incident::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentIncidents',
            'recentUsers',
            'incidentsByCategory',
            'incidentsByStatus'
        ));
    }
}
