<?php

namespace App\Http\Controllers\Auth;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\Auth\RoleRedirectService;
use App\Services\Auth\TwoFactorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TwoFactorChallengeController extends Controller
{
    public function __construct(
        protected TwoFactorService $twoFactorService,
        protected RoleRedirectService $roleRedirectService
    ) {}

    /**
     * Show the two factor authentication challenge view.
     */
    public function create(Request $request): View|RedirectResponse
    {
        if (! $request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        $user = User::find($request->session()->get('login.id'));
        if (! $user) {
            return redirect()->route('login');
        }

        // فحص هل استنفد المستخدم المحاولات المسموحة مسبقاً
        $maxAttempts = (int) config('hospital.two_factor_max_attempts', 5);
        $attemptsKey = "2fa_attempts_{$user->id}";
        $currentAttempts = (int) Cache::get($attemptsKey, 0);

        if ($currentAttempts >= $maxAttempts) {
            $this->twoFactorService->clearPendingTwoFactor($user, $request);

            return redirect()->route('login')->withErrors([
                'email' => trans('auth.two_factor_locked'),
            ]);
        }

        // في البيئة المحلية: ضمان بقاء الكود التجريبي ظاهراً للمطور
        $demoCode = $this->twoFactorService->getDemoCode($user);
        if ($demoCode) {
            $request->session()->put('demo_2fa_code', $demoCode);
        }

        // احتساب الثواني المتبقية لعدّاد الانتظار بين مرات إعادة الإرسال
        $cooldownKey = "2fa_resend_cooldown_{$user->id}";
        $cooldownTarget = (int) Cache::get($cooldownKey, 0);
        $remainingCooldown = max(0, $cooldownTarget - now()->timestamp);

        return view('livewire.auth.two-factor-challenge', [
            'user' => $user,
            'demoCode' => $demoCode,
            'remainingCooldown' => $remainingCooldown,
            'maxAttempts' => $maxAttempts,
            'attemptsLeft' => max(0, $maxAttempts - $currentAttempts),
        ]);
    }

    /**
     * Attempt to authenticate a new session using the two factor authentication code.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! $request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        $userId = $request->session()->get('login.id');
        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('login');
        }

        $maxAttempts = (int) config('hospital.two_factor_max_attempts', 5);
        $attemptsKey = "2fa_attempts_{$user->id}";
        $currentAttempts = (int) Cache::get($attemptsKey, 0);

        // إذا كان المستخدم محظوراً بالفعل بسبب استنفاد المحاولات
        if ($currentAttempts >= $maxAttempts) {
            AuditLog::record(
                action: '2fa_locked',
                email: $user->email,
                userId: $user->id,
                details: ['reason' => 'max_failed_attempts_exceeded', 'attempts' => $currentAttempts],
                request: $request
            );

            $this->twoFactorService->clearPendingTwoFactor($user, $request);

            return redirect()->route('login')->withErrors([
                'email' => trans('auth.two_factor_locked'),
            ]);
        }

        $throttleKey = 'two-factor:' . $userId . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            AuditLog::record(
                action: 'login_locked',
                email: $user->email,
                userId: $user->id,
                details: ['reason' => '2fa_rate_limit_exceeded', 'seconds_remaining' => $seconds],
                request: $request
            );

            throw ValidationException::withMessages([
                'code' => [trans('auth.throttle', ['seconds' => $seconds])],
            ]);
        }

        $request->validate([
            'code' => ['nullable', 'string'],
            'recovery_code' => ['nullable', 'string'],
        ]);

        $code = $request->input('code');
        $recoveryCode = $request->input('recovery_code');

        $isValid = false;

        // 1. التحقق بواسطة كود OTP أو TOTP
        if ($code && $this->twoFactorService->verifyCode($user, $code)) {
            $isValid = true;
        }

        // 2. التحقق بواسطة رمز الاسترداد للطوارئ إن وجد
        if (! $isValid && $recoveryCode && method_exists($user, 'recoveryCodes')) {
            $matched = collect($user->recoveryCodes())->first(function ($rec) use ($recoveryCode) {
                return hash_equals($rec, $recoveryCode);
            });

            if ($matched) {
                $user->replaceRecoveryCode($matched);
                $isValid = true;
            }
        }

        // معالجة المحاولة الخاطئة
        if (! $isValid) {
            RateLimiter::hit($throttleKey, 60);

            $newAttempts = $currentAttempts + 1;
            Cache::put($attemptsKey, $newAttempts, now()->addMinutes(15));
            $remaining = max(0, $maxAttempts - $newAttempts);

            AuditLog::record(
                action: '2fa_failed',
                email: $user->email,
                userId: $user->id,
                details: ['ip' => $request->ip(), 'remaining_attempts' => $remaining],
                request: $request
            );

            // بعد استنفاد 5 محاولات خاطئة: قفل جلسة التحقق وإعادة التوجيه لصفحة الدخول
            if ($newAttempts >= $maxAttempts) {
                AuditLog::record(
                    action: '2fa_locked',
                    email: $user->email,
                    userId: $user->id,
                    details: ['reason' => 'max_failed_attempts_exceeded', 'attempts' => $newAttempts],
                    request: $request
                );

                $this->twoFactorService->clearPendingTwoFactor($user, $request);

                return redirect()->route('login')->withErrors([
                    'email' => trans('auth.two_factor_locked'),
                ]);
            }

            // إبقاء الكود التجريبي ظاهراً للمطور في البيئة المحلية
            if (app()->environment('local')) {
                $demoCode = $this->twoFactorService->getDemoCode($user);
                if ($demoCode) {
                    $request->session()->put('demo_2fa_code', $demoCode);
                }
            }

            throw ValidationException::withMessages([
                'code' => [trans('auth.two_factor_invalid', ['remaining' => $remaining])],
            ]);
        }

        // عند النجاح: تنظيف عدادات المحاولات وجلسة التحقق المؤقتة
        RateLimiter::clear($throttleKey);
        Cache::forget($attemptsKey);
        $this->twoFactorService->clearPendingTwoFactor($user, $request);

        $remember = $request->session()->pull('login.remember', false);
        Auth::login($user, $remember);

        // تجديد الجلسة فوراً بعد اكتمال التحقق بخطوتين لمنع Session Fixation
        $request->session()->regenerate();

        AuditLog::record(
            action: '2fa_success',
            email: $user->email,
            userId: $user->id,
            details: ['role' => $user->role],
            request: $request
        );

        return $this->roleRedirectService->getRedirectForUser($user, $request);
    }

    /**
     * Resend a fresh verification code to the pending user.
     */
    public function resend(Request $request): JsonResponse|RedirectResponse
    {
        if (! $request->session()->has('login.id')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
            return redirect()->route('login');
        }

        $userId = $request->session()->get('login.id');
        $user = User::find($userId);

        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'User not found'], 401);
            }
            return redirect()->route('login');
        }

        // فحص هل تم قفل الحساب بسبب استنفاد المحاولات الخاطئة
        $maxAttempts = (int) config('hospital.two_factor_max_attempts', 5);
        $attemptsKey = "2fa_attempts_{$user->id}";
        if ((int) Cache::get($attemptsKey, 0) >= $maxAttempts) {
            $this->twoFactorService->clearPendingTwoFactor($user, $request);

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => trans('auth.two_factor_locked')], 403);
            }

            return redirect()->route('login')->withErrors([
                'email' => trans('auth.two_factor_locked'),
            ]);
        }

        // 1. فحص عداد الانتظار بين طلبات الإرسال (30 ثانية افتراضياً)
        $cooldownKey = "2fa_resend_cooldown_{$user->id}";
        $cooldownTarget = (int) Cache::get($cooldownKey, 0);
        $remainingCooldown = max(0, $cooldownTarget - now()->timestamp);

        if ($remainingCooldown > 0) {
            $cooldownMsg = trans('auth.two_factor_resend_cooldown', ['seconds' => $remainingCooldown]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $cooldownMsg,
                    'cooldown' => $remainingCooldown,
                ], 429);
            }

            return back()->withErrors(['code' => $cooldownMsg]);
        }

        // 2. فحص الحد الأقصى لإعادة الإرسال (3 مرات كل 10 دقائق) مرتبط بالمستخدم والـ IP
        $resendLimitKey = '2fa-resend:' . $user->id . '|' . $request->ip();
        $maxResends = (int) config('hospital.two_factor_max_resends', 3);
        $resendWindow = (int) config('hospital.two_factor_resend_window', 600);

        if (RateLimiter::tooManyAttempts($resendLimitKey, $maxResends)) {
            $availableIn = RateLimiter::availableIn($resendLimitKey);
            $minutes = max(1, (int) ceil($availableIn / 60));
            $limitMsg = trans('auth.two_factor_resend_limit_exceeded', ['minutes' => $minutes]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $limitMsg,
                ], 429);
            }

            return back()->withErrors(['code' => $limitMsg]);
        }

        // تسجيل المحاولة في RateLimiter وتثبيت عداد الانتظار في الكاش
        RateLimiter::hit($resendLimitKey, $resendWindow);

        $cooldownDuration = (int) config('hospital.two_factor_resend_cooldown', 30);
        Cache::put($cooldownKey, now()->addSeconds($cooldownDuration)->timestamp, $cooldownDuration);

        // توليد رمز جديد وإلغاء القديم وتجديد مدة الصلاحية
        $newCode = $this->twoFactorService->resendOtp($user, $request);

        $successMsg = trans('auth.two_factor_code_resent');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
                'cooldown' => $cooldownDuration,
                'demo_code' => app()->environment('local') ? $newCode : null,
            ]);
        }

        return back()->with('status', $successMsg);
    }
}

