<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMustChangePassword
{
    /**
     * Handle an incoming request.
     * Checks if the user is required to change password on first login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->must_change_password) {
            // Allow access to password change routes and logout route
            if ($request->routeIs('password.change.force', 'password.change.update', 'logout')) {
                return $next($request);
            }

            return redirect()->route('password.change.force')
                ->with('warning', __('auth.must_change_password_notice'));
        }

        return $next($request);
    }
}
