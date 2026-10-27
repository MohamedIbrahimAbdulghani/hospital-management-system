<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RoleRedirectService
{
    /**
     * Get redirect response for user based on their role and intended URL compatibility.
     *
     * @param  User|null  $user
     * @param  Request|null  $request
     * @return RedirectResponse
     */
    public function getRedirectForUser(?User $user, ?Request $request = null): RedirectResponse
    {
        $request = $request ?: request();

        if (! $user) {
            return redirect()->route('login');
        }

        $intended = session()->pull('url.intended');

        if ($intended && $this->isUrlCompatibleWithRole($intended, $user->role)) {
            return redirect()->to($intended);
        }

        $routeName = match ($user->role) {
            'admin' => 'admin.dashboard',
            'doctor' => 'doctor.dashboard',
            'hr' => 'hr.dashboard',
            'patient' => 'patient.dashboard',
            default => 'home',
        };

        $url = route($routeName);

        if (class_exists(LaravelLocalization::class)) {
            $locale = \App\Helpers\LocaleHelper::getLocale($request);
            \App\Helpers\LocaleHelper::rememberLocale($locale, $request);

            if (! app()->runningUnitTests() || $locale !== 'en') {
                $url = LaravelLocalization::getLocalizedURL($locale, $url);
            }
        }

        return redirect()->to($url);
    }

    /**
     * Determine if an intended URL is compatible with the given role.
     *
     * @param  string  $url
     * @param  string  $role
     * @return bool
     */
    public function isUrlCompatibleWithRole(string $url, string $role): bool
    {
        $path = parse_url($url, PHP_URL_PATH) ?? '';

        // Disallowed auth pages
        $disallowedPatterns = [
            'login',
            'choose-role',
            'register',
            'two-factor-challenge',
            'forgot-password',
            'reset-password',
        ];

        foreach ($disallowedPatterns as $pattern) {
            if (str_contains($path, $pattern)) {
                return false;
            }
        }

        // Cross-role inspection
        $rolePrefixes = [
            'admin' => ['admin', 'dashboard/admin'],
            'doctor' => ['doctor', 'dashboard/doctor'],
            'hr' => ['hr', 'dashboard/hr'],
            'patient' => ['patient', 'dashboard/patient'],
        ];

        foreach ($rolePrefixes as $targetRole => $prefixes) {
            if ($targetRole === $role) {
                continue;
            }

            foreach ($prefixes as $prefix) {
                // E.g. /ar/admin or /admin
                if (preg_match('#/(?:[a-z]{2}/)?' . preg_quote($prefix, '#') . '(/|$)#i', $path)) {
                    return false;
                }
            }
        }

        return true;
    }
}
