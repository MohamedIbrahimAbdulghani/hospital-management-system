<?php

use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\DoctorDashboardController;
use App\Http\Controllers\Dashboard\HrDashboardController;
use App\Http\Controllers\Dashboard\PatientDashboardController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath',
    ],
], function () {

    // 1. Admin Portal Routes: /admin/dashboard
    Route::middleware(['auth', 'role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('/settings', [\App\Http\Controllers\Dashboard\AdminSettingsController::class, 'index'])->name('settings.index');
            Route::post('/settings', [\App\Http\Controllers\Dashboard\AdminSettingsController::class, 'update'])->name('settings.update');
        });
    Route::get('/dashboard/admin', fn () => redirect()->route('admin.dashboard'))
        ->middleware(['auth', 'role:admin']);

    // 2. Doctor Portal Routes: /doctor/dashboard
    Route::middleware(['auth', 'role:doctor'])
        ->prefix('doctor')
        ->name('doctor.')
        ->group(function () {
            Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
        });
    Route::get('/dashboard/doctor', fn () => redirect()->route('doctor.dashboard'))
        ->middleware(['auth', 'role:doctor']);

    // 3. HR Portal Routes: /hr/dashboard
    Route::middleware(['auth', 'role:hr'])
        ->prefix('hr')
        ->name('hr.')
        ->group(function () {
            Route::get('/dashboard', [HrDashboardController::class, 'index'])->name('dashboard');
        });
    Route::get('/dashboard/hr', fn () => redirect()->route('hr.dashboard'))
        ->middleware(['auth', 'role:hr']);

    // 4. Patient Portal Routes: /patient/dashboard
    Route::middleware(['auth', 'role:patient'])
        ->prefix('patient')
        ->name('patient.')
        ->group(function () {
            Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
        });
    Route::get('/dashboard/patient', fn () => redirect()->route('patient.dashboard'))
        ->middleware(['auth', 'role:patient']);
});
