<?php

use App\Http\Controllers\LocalizationController;
use App\Livewire\Auth\ForceChangePassword;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Security;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\TwoFactorChallengeController;


// راوت تبديل اللغة الموحد لجميع صفحات الموقع
Route::get('/locale/{locale}', [LocalizationController::class, 'switch'])->name('locale.switch');

// تحويل أي طلب مباشر لـ /login أو /register بدون بادئة لغة إلى الرابط المحتوي على اللغة تلقائياً
Route::get('/login', function () {
    return redirect()->to(LaravelLocalization::getLocalizedURL(null, 'login'));
});
Route::get('/register', function () {
    return redirect()->to(LaravelLocalization::getLocalizedURL(null, 'register'));
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'localeSessionRedirect',
        'localizationRedirect',
        'localeViewPath',
    ],
], function () {
    // صفحة تسجيل الدخول الموحدة ببادئة اللغة (/ar/login أو /en/login)
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware(['guest:'.config('fortify.guard')])
        ->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(['guest:'.config('fortify.guard')]);

    // صفحة إنشاء حساب جديد ببادئة اللغة (/ar/register أو /en/register)
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->middleware(['guest:'.config('fortify.guard')])
        ->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware(['guest:'.config('fortify.guard')]);

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/welcome', fn () => redirect()->route('home'))->name('welcome');

    Route::get('/choose-role', fn () => redirect()->route('login'))->name('choose-role');

    // Two-Factor Authentication Challenge
    Route::get('/two-factor-challenge', [TwoFactorChallengeController::class, 'create'])
        ->name('two-factor.login');
    Route::post('/two-factor-challenge', [TwoFactorChallengeController::class, 'store'])
        ->name('two-factor.login.store');

    // Central dashboard redirect based on authenticated user role
    Route::get('/dashboard', function () {
        // Will be intercepted and directed by role_redirect middleware
    })->middleware(['auth', 'role_redirect'])->name('dashboard');

    // Forced password change route
    Route::middleware(['auth'])->group(function () {
        Route::get('/password/force-change', ForceChangePassword::class)->name('password.change.force');

        Route::get('/settings/profile', Profile::class)->name('profile.edit');
        Route::get('/settings/security', Security::class)->name('security.edit');
        Route::get('/settings/appearance', Appearance::class)->name('appearance.edit');
    });
});
