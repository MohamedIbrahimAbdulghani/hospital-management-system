<?php

use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\AdminSettingsController;
use App\Http\Controllers\Dashboard\DoctorDashboardController;
use App\Http\Controllers\Dashboard\HrDashboardController;
use App\Http\Controllers\Dashboard\PatientDashboardController;
use App\Http\Controllers\Dashboard\SectionController;
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

    // ==========================================
    // 1. بوابة مدير النظام (Admin Portal)
    // ==========================================
    Route::middleware(['auth', 'role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // لوحة التحكم والإعدادات
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
            Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

            // إدارة الأقسام الطبية
            Route::resource('sections', SectionController::class);
        });

    // تحويل المسار القديم للوحة تحكم الأدمن
    Route::get('/dashboard/admin', fn () => redirect()->route('admin.dashboard'))
        ->middleware(['auth', 'role:admin']);


    // ==========================================
    // 2. بوابة الأطباء (Doctor Portal)
    // ==========================================
    Route::middleware(['auth', 'role:doctor'])
        ->prefix('doctor')
        ->name('doctor.')
        ->group(function () {
            Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
        });

    // تحويل المسار القديم لبوابة الطبيب
    Route::get('/dashboard/doctor', fn () => redirect()->route('doctor.dashboard'))
        ->middleware(['auth', 'role:doctor']);


    // ==========================================
    // 3. بوابة الموارد البشرية (HR Portal)
    // ==========================================
    Route::middleware(['auth', 'role:hr'])
        ->prefix('hr')
        ->name('hr.')
        ->group(function () {
            Route::get('/dashboard', [HrDashboardController::class, 'index'])->name('dashboard');
        });

    // تحويل المسار القديم لبوابة الموارد البشرية
    Route::get('/dashboard/hr', fn () => redirect()->route('hr.dashboard'))
        ->middleware(['auth', 'role:hr']);


    // ==========================================
    // 4. بوابة المرضى (Patient Portal)
    // ==========================================
    Route::middleware(['auth', 'role:patient'])
        ->prefix('patient')
        ->name('patient.')
        ->group(function () {
            Route::get('/dashboard', [PatientDashboardController::class, 'index'])->name('dashboard');
        });

    // تحويل المسار القديم لبوابة المريض
    Route::get('/dashboard/patient', fn () => redirect()->route('patient.dashboard'))
        ->middleware(['auth', 'role:patient']);
});
