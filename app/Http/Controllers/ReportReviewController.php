<?php

namespace App\Http\Controllers;

use App\Models\FireReport;
use App\Models\ReportReview;
use Illuminate\Http\Request;

class ReportReviewController extends Controller
{
    public function index()
    {
        $reports = FireReport::with(['user', 'area'])
            ->latest()
            ->paginate(10);

        return view('report-reviews.index', compact('reports'));
    }

    public function show(FireReport $fireReport)
    {
        $fireReport->load(['user', 'area', 'reviews.reviewer']);

        return view('report-reviews.show', compact('fireReport'));
    }

    public function store(Request $request, FireReport $fireReport)
    {
        if ($fireReport->status !== 'menunggu_peninjauan') {
            abort(403, 'Laporan sudah tidak dapat ditinjau.');
        }
        $validated = $request->validate([
            'note' => 'required|string',
        ]);

        ReportReview::create([
            'fire_report_id' => $fireReport->id,
            'reviewer_id' => auth()->id(),
            'note' => $validated['note'],
        ]);

        return redirect()
            ->route('report-reviews.show', $fireReport->id)
            ->with('success', 'Catatan peninjauan berhasil disimpan.');
    }
}
