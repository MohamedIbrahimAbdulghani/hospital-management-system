<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Enums\UserRole;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SpecializationPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     * Admin has unrestricted access.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any specializations.
     */
    public function viewAny(User $user): bool
    {
        return true; // Any authenticated user can view active specializations
    }

    /**
     * Determine whether the user can view the specialization.
     */
    public function view(User $user, Specialization $specialization): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create specializations.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Permission::MANAGE_SPECIALIZATIONS->value)
            || $user->hasPermissionTo('manage_specializations');
    }

    /**
     * Determine whether the user can update the specialization.
     */
    public function update(User $user, Specialization $specialization): bool
    {
        return $user->hasPermissionTo(Permission::MANAGE_SPECIALIZATIONS->value)
            || $user->hasPermissionTo('manage_specializations');
    }

    /**
     * Determine whether the user can delete the specialization.
     */
    public function delete(User $user, Specialization $specialization): bool
    {
        return $user->hasPermissionTo(Permission::MANAGE_SPECIALIZATIONS->value)
            || $user->hasPermissionTo('manage_specializations');
    }
}
