<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
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
     * Determine whether the user can view any sections.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the section.
     */
    public function view(User $user, Section $section): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create sections.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(Permission::MANAGE_SECTIONS->value)
            || $user->hasPermissionTo('manage_sections');
    }

    /**
     * Determine whether the user can update the section.
     */
    public function update(User $user, Section $section): bool
    {
        return $user->hasPermissionTo(Permission::MANAGE_SECTIONS->value)
            || $user->hasPermissionTo('manage_sections');
    }

    /**
     * Determine whether the user can delete the section.
     */
    public function delete(User $user, Section $section): bool
    {
        return $user->hasPermissionTo(Permission::MANAGE_SECTIONS->value)
            || $user->hasPermissionTo('manage_sections');
    }
}
