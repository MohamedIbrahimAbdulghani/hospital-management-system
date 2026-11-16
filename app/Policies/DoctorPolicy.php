<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DoctorPolicy
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
     * Determine whether the user can view any doctors.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permission::MANAGE_DOCTORS->value)
            || $user->hasPermissionTo('manage_doctors')
            || $user->isHr();
    }

    /**
     * Determine whether the user can view the doctor profile.
     */
    public function view(User $user, Doctor $doctor): bool
    {
        // Doctor can view their own profile, or HR / Admin can view
        return $user->id === $doctor->user_id
            || $user->hasPermissionTo(Permission::MANAGE_DOCTORS->value)
            || $user->hasPermissionTo('manage_doctors');
    }

    /**
     * Determine whether the user can update the doctor profile.
     */
    public function update(User $user, Doctor $doctor): bool
    {
        // Doctor can update their own profile, or HR / Admin can update
        return $user->id === $doctor->user_id
            || $user->hasPermissionTo(Permission::MANAGE_DOCTORS->value)
            || $user->hasPermissionTo('manage_doctors');
    }

    /**
     * Determine whether the user can manage the doctor's schedule.
     */
    public function manageSchedule(User $user, Doctor $doctor): bool
    {
        return $user->id === $doctor->user_id
            || $user->hasPermissionTo(Permission::MANAGE_DOCTOR_SCHEDULE->value)
            || $user->hasPermissionTo('manage_doctor_schedule');
    }

    /**
     * Determine whether the user can delete the doctor.
     */
    public function delete(User $user, Doctor $doctor): bool
    {
        return $user->hasPermissionTo(Permission::MANAGE_DOCTORS->value)
            || $user->hasPermissionTo('manage_doctors');
    }
}
