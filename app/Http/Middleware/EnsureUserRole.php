<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     * Checks if the authenticated user has the specified role(s).
     * Supports both Spatie permission roles and User->role column with auto-healing.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|array  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Flatten roles if pipe or comma separated
        $allowedRoles = [];
        foreach ($roles as $role) {
            foreach (explode('|', $role) as $subRole) {
                $trimmed = trim($subRole);
                if ($trimmed !== '') {
                    $allowedRoles[] = $trimmed;
                }
            }
        }

        // Check if user has role either via users.role or Spatie's hasAnyRole
        $hasRole = in_array($user->role, $allowedRoles, true) || $user->hasAnyRole($allowedRoles);

        if (! $hasRole) {
            throw UnauthorizedException::forRoles($allowedRoles);
        }

        // Auto-heal: Ensure Spatie role is synchronized with users.role if out of sync
        if ($user->role && ! $user->hasRole($user->role)) {
            $user->syncRoles([$user->role]);
        }

        return $next($request);
    }
}
