<?php

namespace App\Http\Controllers;

use App\Models\FireReport;
use Illuminate\Http\Request;

class ReportStatusController extends Controller
{
    public function update(Request $request, FireReport $fireReport)
    {
        $validated = $request->validate([
            'status' => 'required|in:perlu_tindak_lanjut,sedang_ditindaklanjuti,selesai',
        ]);

        $currentRole = auth()->user()->role;
        $currentStatus = $fireReport->status;
        $newStatus = $validated['status'];

        // Relawan menandai laporan yang perlu ditindaklanjuti.
        if (
            $currentRole === 'relawan' &&
            $currentStatus === 'menunggu_peninjauan' &&
            $newStatus === 'perlu_tindak_lanjut'
        ) {
            $fireReport->update([
                'status' => $newStatus,
            ]);
        }

        // Koordinator mencatat penerusan informasi.
        elseif (
            $currentRole === 'koordinator' &&
            $currentStatus === 'perlu_tindak_lanjut' &&
            $newStatus === 'sedang_ditindaklanjuti'
        ) {
            $fireReport->update([
                'status' => $newStatus,
            ]);
        }

        // Koordinator menyelesaikan proses dalam aplikasi.
        elseif (
            $currentRole === 'koordinator' &&
            $currentStatus === 'sedang_ditindaklanjuti' &&
            $newStatus === 'selesai'
        ) {
            $fireReport->update([
                'status' => $newStatus,
            ]);
        }

        else {
            abort(403, 'Perubahan status tidak diizinkan.');
        }

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}
