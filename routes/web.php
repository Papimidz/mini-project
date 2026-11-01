<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
});
