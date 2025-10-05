<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function stats(Request $request)
    {
        $totalReports = Incident::count();
        $verifiedReports = Incident::where('is_verified', true)->count();
        
        // Count distinct locations (districts) with incidents
        $activeLocations = Incident::whereNotNull('district')
            ->distinct()
            ->pluck('district')
            ->count();
        
        // Count resolved incidents today
        $resolvedToday = Incident::where('status', 'resolved')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        return response()->json([
            'totalReports' => $totalReports,
            'verifiedReports' => $verifiedReports,
            'activeLocations' => $activeLocations,
            'resolvedToday' => $resolvedToday,
        ]);
    }

    public function trends(Request $request)
    {
        // Implementation for trends if needed
        return response()->json([
            'message' => 'Trends endpoint'
        ]);
    }

    public function detailed(Request $request)
    {
        // Get incidents by category
        $byCategory = Incident::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        // Get incidents by status
        $byStatus = Incident::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Get top locations
        $topLocations = Incident::selectRaw('district, division, COUNT(*) as count')
            ->whereNotNull('district')
            ->whereNotNull('division')
            ->groupBy('district', 'division')
            ->orderByDesc('count')
            ->limit(9)
            ->get()
            ->map(function($item) {
                return [
                    'district' => $item->district,
                    'division' => $item->division,
                    'count' => $item->count
                ];
            });

        return response()->json([
            'byCategory' => $byCategory,
            'byStatus' => $byStatus,
            'topLocations' => $topLocations
        ]);
    }
}
