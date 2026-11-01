<?php

namespace App\Observers;

use App\Models\FireReport;
use Illuminate\Support\Facades\Log;

class FireReportObserver
{
    public function updated(FireReport $fireReport): void
    {
        if ($fireReport->wasChanged('status')) {
            Log::info('Status laporan kebakaran berubah.', [
                'report_id' => $fireReport->id,
                'old_status' => $fireReport->getOriginal('status'),
                'new_status' => $fireReport->status,
                'changed_by' => auth()->id(),
                'changed_at' => now()->toDateTimeString(),
            ]);
        }
    }
}
