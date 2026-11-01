<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\FireReport;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = FireReport::with(['user', 'area']);

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        $totalReports = (clone $query)->count();

        $waitingReports = (clone $query)
            ->where('status', 'menunggu_peninjauan')
            ->count();

        $completedReports = (clone $query)
            ->where('status', 'selesai')
            ->count();

        $reports = (clone $query)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $areas = Area::orderBy('name')->get();

        return view('dashboard.koordinator', compact(
            'totalReports',
            'waitingReports',
            'completedReports',
            'reports',
            'areas'
        ));
    }
}
