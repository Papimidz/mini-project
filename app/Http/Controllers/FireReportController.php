<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\FireReport;
use Illuminate\Http\Request;

class FireReportController extends Controller
{
    public function index(Request $request)
    {
        $query = FireReport::with(['user', 'area']);

        if (auth()->user()->role === 'pelapor') {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        if ($request->filled('condition_level')) {
            $query->where('condition_level', $request->condition_level);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $areas = Area::orderBy('name')->get();

        return view('fire-reports.index', compact('reports', 'areas'));
    }
    public function areaReports(Area $area)
    {
        $reports = FireReport::with('user')
            ->where('area_id', $area->id)
            ->where('status', '!=', 'selesai')
            ->latest()
            ->get();

        return response()->json([
            'area' => $area->name,
            'total_reports' => $reports->count(),
            'reports' => $reports->map(function ($report) {
                return [
                    'title' => $report->title,
                    'reporter' => $report->user->name,
                    'condition_level' => $report->condition_level,
                    'status' => $report->status,
                    'incident_at' => $report->incident_at->format('d-m-Y H:i'),
                ];
            }),
        ]);
    }
    public function create()
    {
        $areas = Area::orderBy('name')->get();

        return view('fire-reports.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'area_id' => 'required|exists:areas,id',
            'incident_at' => 'required|date',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'condition_level' => 'required|in:rendah,sedang,tinggi',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $evidencePath = null;

        if ($request->hasFile('evidence')) {
            $evidencePath = $request->file('evidence')
                ->store('evidence', 'public');
        }

        FireReport::create([
            'user_id' => auth()->id(),
            'area_id' => $validated['area_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'incident_at' => $validated['incident_at'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'condition_level' => $validated['condition_level'],
            'status' => 'menunggu_peninjauan',
            'evidence_path' => $evidencePath,
        ]);

        return redirect()->route('fire-reports.index')
            ->with('success', 'Laporan berhasil dikirim.');
    }
}