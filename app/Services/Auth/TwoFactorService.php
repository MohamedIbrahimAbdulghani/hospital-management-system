<?php

namespace App\Services\Auth;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;

class TwoFactorService
{
    /**
     * Determine if Two Factor Authentication is required for this user.
     * Mandatory for configured roles (default: admin only), or any user who voluntarily enabled 2FA.
     */
    public function isTwoFactorRequired(User $user): bool
    {
        // التحقق من الأدوار الملزمة بالتحقق الثنائي عبر ملف الإعدادات
        $configuredRoles = (array) config('hospital.two_factor_roles', ['admin']);

        foreach ($configuredRoles as $role) {
            if ($user->role === $role || $user->hasRole($role)) {
                return true;
            }
        }

        return ! empty($user->two_factor_secret);
    }

    /**
     * Generate an OTP code for user, cache it, and record audit log.
     */
    public function generateAndSendOtp(User $user, ?Request $request = null, bool $isResend = false): string
    {
        $code = sprintf('%06d', random_int(100000, 999999));
        $expiryMinutes = (int) config('hospital.two_factor_expiry_minutes', 5);

        // تخزين الرمز مجزّأً في الكاش للحماية القصوى
        Cache::put("2fa_otp_{$user->id}", Hash::make($code), now()->addMinutes($expiryMinutes));

        // تخزين الكود التجريبي للمطور في البيئة المحلية فقط مع بقائه طوال مدة الصلاحية
        if (app()->environment('local')) {
            Cache::put("2fa_demo_code_{$user->id}", $code, now()->addMinutes($expiryMinutes));
            session()->put('demo_2fa_code', $code);
        } else {
            Cache::forget("2fa_demo_code_{$user->id}");
            session()->forget('demo_2fa_code');
        }

        // الأمان: لا نسجل كود التحقق أبداً في السجلات العامة
        Log::info("HMS 2FA verification code generated for {$user->email}");

        // تسجيل الحدث في سجل التدقيق الأمني بدون الكود
        AuditLog::record(
            action: $isResend ? '2fa_resent' : '2fa_challenged',
            email: $user->email,
            userId: $user->id,
            details: ['role' => $user->role, 'method' => 'otp_and_totp'],
            request: $request
        );

        return $code;
    }

    /**
     * Resend a fresh OTP code to user, invalidating any previous code.
     * Failed attempts counter is intentionally preserved to prevent bypasses.
     */
    public function resendOtp(User $user, ?Request $request = null): string
    {
        // إلغاء الكود القديم فوراً
        Cache::forget("2fa_otp_{$user->id}");
        Cache::forget("2fa_demo_code_{$user->id}");

        // توليد كود جديد وتجديد الصلاحية
        return $this->generateAndSendOtp($user, $request, isResend: true);
    }

    /**
     * Retrieve the dev demo code strictly in local environment.
     */
    public function getDemoCode(User $user): ?string
    {
        if (! app()->environment('local')) {
            return null;
        }

        return Cache::get("2fa_demo_code_{$user->id}") ?? session('demo_2fa_code');
    }

    /**
     * Clear all pending two-factor data for this user.
     */
    public function clearPendingTwoFactor(User $user, ?Request $request = null): void
    {
        Cache::forget("2fa_otp_{$user->id}");
        Cache::forget("2fa_demo_code_{$user->id}");
        Cache::forget("2fa_attempts_{$user->id}");
        Cache::forget("2fa_resend_cooldown_{$user->id}");

        $req = $request ?: request();
        if ($req && $req->hasSession()) {
            $req->session()->forget(['login.id', 'login.remember', 'demo_2fa_code']);
        }
    }

    /**
     * Verify the supplied code against Cache OTP or TOTP Authenticator.
     */
    public function verifyCode(User $user, string $code): bool
    {
        $code = trim($code);

        // 1. Check cached OTP
        $hashedOtp = Cache::get("2fa_otp_{$user->id}");
        if ($hashedOtp && Hash::check($code, $hashedOtp)) {
            Cache::forget("2fa_otp_{$user->id}");
            Cache::forget("2fa_demo_code_{$user->id}");
            return true;
        }

        // 2. Check TOTP Authenticator if configured
        if (! empty($user->two_factor_secret)) {
            try {
                $provider = app(TwoFactorAuthenticationProvider::class);
                if ($provider->verify(decrypt($user->two_factor_secret), $code)) {
                    return true;
                }
            } catch (\Throwable $e) {
                Log::warning("TOTP verification error: " . $e->getMessage());
            }
        }

        // 3. Convenience demo fallback strictly for local development with debug enabled
        if (app()->environment('local') && config('app.debug') && $code === '123456') {
            return true;
        }

        return false;
    }
}

