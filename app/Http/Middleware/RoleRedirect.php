<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     * Redirects users to their role-specific dashboard.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $routeName = match ($user->role) {
            'admin' => 'admin.dashboard',
            'doctor' => 'doctor.dashboard',
            'hr' => 'hr.dashboard',
            'patient' => 'patient.dashboard',
            default => null,
        };

        if ($routeName) {
            $url = route($routeName);
            if (class_exists(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::class)) {
                $locale = session('locale', app()->getLocale());
                $url = \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($locale, $url);
            }

            return redirect()->to($url);
        }

        return $next($request);
    }
}
