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
     * Mandatory for Admin and Doctor, or any user who voluntarily enabled 2FA.
     */
    public function isTwoFactorRequired(User $user): bool
    {
        if ($user->isAdmin() || $user->isDoctor()) {
            return true;
        }

        return ! empty($user->two_factor_secret);
    }

    /**
     * Generate an OTP code for user, cache it, and record audit log.
     */
    public function generateAndSendOtp(User $user, ?Request $request = null): string
    {
        $code = sprintf('%06d', random_int(100000, 999999));

        Cache::put("2fa_otp_{$user->id}", Hash::make($code), now()->addMinutes(10));

        // For local development / review, flash demo code to session so testing is effortless
        if (app()->environment('local', 'testing') || config('app.debug')) {
            session()->flash('demo_2fa_code', $code);
        }

        Log::info("HMS 2FA Verification Code for {$user->email}: [{$code}]");

        AuditLog::record(
            action: '2fa_challenged',
            email: $user->email,
            userId: $user->id,
            details: ['role' => $user->role, 'method' => 'otp_and_totp'],
            request: $request
        );

        return $code;
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

        // 3. Convenience demo fallback for local / testing
        if ((app()->environment('local', 'testing') || config('app.debug')) && $code === '123456') {
            return true;
        }

        return false;
    }
}
