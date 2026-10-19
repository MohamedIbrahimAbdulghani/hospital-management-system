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

    // 1. Admin Portal Routes
    Route::middleware(['auth', 'role:admin'])
        ->prefix('dashboard/admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        });

    // 2. Doctor Portal Routes
    Route::middleware(['auth', 'role:doctor'])
        ->prefix('dashboard/doctor')
        ->name('doctor.')
        ->group(function () {
            Route::get('/', [DoctorDashboardController::class, 'index'])->name('dashboard');
        });

    // 3. HR Portal Routes
    Route::middleware(['auth', 'role:hr'])
        ->prefix('dashboard/hr')
        ->name('hr.')
        ->group(function () {
            Route::get('/', [HrDashboardController::class, 'index'])->name('dashboard');
        });

    // 4. Patient Portal Routes
    Route::middleware(['auth', 'role:patient'])
        ->prefix('dashboard/patient')
        ->name('patient.')
        ->group(function () {
            Route::get('/', [PatientDashboardController::class, 'index'])->name('dashboard');
        });
});
