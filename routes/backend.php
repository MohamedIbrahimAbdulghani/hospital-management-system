<?php


use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
    ],
], function () {
    Route::get('/dashboard_admin', [
        DashboardController::class,
        'index',
    ])->name('dashboard_admin');
});
