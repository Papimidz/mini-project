<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\FireReport;
use App\Observers\FireReportObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        FireReport::observe(FireReportObserver::class);
    }
}
