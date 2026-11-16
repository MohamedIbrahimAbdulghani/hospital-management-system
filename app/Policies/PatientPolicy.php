<?php

namespace App\Policies;

use App\Enums\Permission;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PatientPolicy
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
     * Determine whether the user can view any patients.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(Permission::VIEW_PATIENTS->value)
            || $user->hasPermissionTo('view_patients')
            || $user->isDoctor()
            || $user->isHr();
    }

    /**
     * Determine whether the user can view the specific patient.
     */
    public function view(User $user, Patient $patient): bool
    {
        // Patient can view their own profile, or authorized staff
        return $user->id === $patient->user_id
            || $user->hasPermissionTo(Permission::VIEW_PATIENTS->value)
            || $user->hasPermissionTo('view_patients')
            || $user->isDoctor()
            || $user->isHr();
    }

    /**
     * Determine whether the user can update the patient.
     */
    public function update(User $user, Patient $patient): bool
    {
        // Patient can update their own profile, or HR / Admin
        return $user->id === $patient->user_id
            || $user->hasPermissionTo(Permission::MANAGE_PATIENTS->value)
            || $user->hasPermissionTo('manage_patients');
    }

    /**
     * Determine whether the user can view medical records of this patient.
     */
    public function viewMedicalRecords(User $user, Patient $patient): bool
    {
        return $user->id === $patient->user_id
            || $user->hasPermissionTo(Permission::VIEW_MEDICAL_RECORDS->value)
            || $user->hasPermissionTo('view_medical_records')
            || $user->isDoctor();
    }

    /**
     * Determine whether the user can delete the patient.
     */
    public function delete(User $user, Patient $patient): bool
    {
        return $user->hasPermissionTo(Permission::MANAGE_PATIENTS->value)
            || $user->hasPermissionTo('manage_patients');
    }
}
