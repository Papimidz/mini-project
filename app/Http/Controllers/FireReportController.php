<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\FireReport;
use Illuminate\Http\Request;

class FireReportController extends Controller
{
    public function index()
    {
        $reports = FireReport::with(['user', 'area'])
            ->latest()
            ->paginate(10);

        return view('fire-reports.index', compact('reports'));
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