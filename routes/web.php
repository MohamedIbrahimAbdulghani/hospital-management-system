<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Security;
use App\Livewire\Settings\Appearance;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
    ],
], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::view('/dashboard', 'dashboard')
        ->middleware('auth')
        ->name('dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::get('/settings/profile', Profile::class)->name('profile.edit');
        Route::get('/settings/security', Security::class)->name('security.edit');
        Route::get('/settings/appearance', Appearance::class)->name('appearance.edit');
    });
});