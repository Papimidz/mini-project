<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\FireReportController;
use App\Http\Controllers\ReportReviewController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');



    Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/pelapor', function () {
        return view('dashboard.pelapor');
    })->middleware('role:pelapor')->name('dashboard.pelapor');

    Route::get('/relawan', function () {
        return view('dashboard.relawan');
    })->middleware('role:relawan')->name('dashboard.relawan');

    Route::get('/koordinator', function () {
        return view('dashboard.koordinator');
    })->middleware('role:koordinator')->name('dashboard.koordinator');

    Route::get('/areas', [AreaController::class, 'index'])
        ->middleware('role:koordinator')
        ->name('areas.index');

    Route::get('/areas/create', [AreaController::class, 'create'])
        ->middleware('role:koordinator')
        ->name('areas.create');

    Route::post('/areas', [AreaController::class, 'store'])
        ->middleware('role:koordinator')
        ->name('areas.store');
    Route::get('/areas/{area}/edit', [AreaController::class, 'edit'])
        ->middleware('role:koordinator')
        ->name('areas.edit');

    Route::put('/areas/{area}', [AreaController::class, 'update'])
        ->middleware('role:koordinator')
        ->name('areas.update');

    Route::delete('/areas/{area}', [AreaController::class, 'destroy'])
        ->middleware('role:koordinator')
        ->name('areas.destroy');
});
Route::middleware('auth')->group(function () {
    Route::get('/fire-reports', [FireReportController::class, 'index'])
        ->name('fire-reports.index');

    Route::get('/fire-reports/create', [FireReportController::class, 'create'])
        ->name('fire-reports.create');

    Route::post('/fire-reports', [FireReportController::class, 'store'])
        ->name('fire-reports.store');
});
Route::middleware(['auth', 'role:relawan'])->group(function () {
    Route::get('/report-reviews', [ReportReviewController::class, 'index'])
        ->name('report-reviews.index');

    Route::get('/report-reviews/{fireReport}', [ReportReviewController::class, 'show'])
        ->name('report-reviews.show');

    Route::post('/report-reviews/{fireReport}', [ReportReviewController::class, 'store'])
        ->name('report-reviews.store');
});