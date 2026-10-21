<?php

namespace App\Http\Controllers\Auth;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\Auth\RoleRedirectService;
use App\Services\Auth\TwoFactorService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TwoFactorChallengeController extends Controller
{
    public function __construct(
        protected TwoFactorService $twoFactorService,
        protected RoleRedirectService $roleRedirectService
    ) {}

    /**
     * Show the two factor authentication challenge view.
     */
    public function create(Request $request)
    {
        if (! $request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        $user = User::find($request->session()->get('login.id'));
        if (! $user) {
            return redirect()->route('login');
        }

        return view('livewire.auth.two-factor-challenge', [
            'user' => $user,
        ]);
    }

    /**
     * Attempt to authenticate a new session using the two factor authentication code.
     */
    public function store(Request $request)
    {
        if (! $request->session()->has('login.id')) {
            return redirect()->route('login');
        }

        $userId = $request->session()->get('login.id');
        $user = User::find($userId);

        if (! $user) {
            return redirect()->route('login');
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

        // 1. Verify via code (OTP or TOTP)
        if ($code && $this->twoFactorService->verifyCode($user, $code)) {
            $isValid = true;
        }

        // 2. Verify via recovery code if provided
        if (! $isValid && $recoveryCode && method_exists($user, 'recoveryCodes')) {
            $matched = collect($user->recoveryCodes())->first(function ($rec) use ($recoveryCode) {
                return hash_equals($rec, $recoveryCode);
            });

            if ($matched) {
                $user->replaceRecoveryCode($matched);
                $isValid = true;
            }
        }

        if (! $isValid) {
            RateLimiter::hit($throttleKey, 60);

            AuditLog::record(
                action: '2fa_failed',
                email: $user->email,
                userId: $user->id,
                details: ['ip' => $request->ip()],
                request: $request
            );

            throw ValidationException::withMessages([
                'code' => [app()->getLocale() === 'ar'
                    ? 'رمز التحقق غير صحيح أو انتهت صلاحيته.'
                    : 'The provided two factor authentication code was invalid.'],
            ]);
        }

        // Success: clear rate limiter and temporary login id
        RateLimiter::clear($throttleKey);
        $request->session()->forget('login.id');

        $remember = $request->session()->pull('login.remember', false);
        Auth::login($user, $remember);

        // Regenerate session immediately after successful 2FA
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
}
