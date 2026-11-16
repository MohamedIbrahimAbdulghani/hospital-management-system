<?php

namespace Database\Seeders;

use App\Enums\Permission as AppPermission;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Register modern Enum permissions
        foreach (AppPermission::values() as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);
        }

        // 2. Register legacy snake_case aliases for 100% backwards compatibility
        $legacyPermissions = [
            'access_admin_dashboard',
            'manage_users',
            'manage_roles_permissions',
            'manage_specializations',
            'view_system_logs',
            'access_doctor_dashboard',
            'manage_doctors',
            'view_doctor_schedule',
            'manage_doctor_schedule',
            'access_patient_dashboard',
            'manage_patients',
            'view_patients',
            'access_hr_dashboard',
            'manage_hr_staff',
            'view_appointments',
            'book_appointments',
            'reschedule_appointments',
            'cancel_appointments',
            'view_medical_records',
            'create_medical_records',
            'edit_medical_records',
            'download_medical_reports',
            'manage_invoices',
            'view_invoices',
            'process_payments',
            'chat_direct',
        ];

        foreach ($legacyPermissions as $legacyName) {
            Permission::firstOrCreate(['name' => $legacyName, 'guard_name' => 'web']);
        }

        // 3. Admin Role (Has all permissions)
        $adminRole = Role::firstOrCreate(['name' => UserRole::ADMIN->value, 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // 4. Doctor Role
        $doctorRole = Role::firstOrCreate(['name' => UserRole::DOCTOR->value, 'guard_name' => 'web']);
        $doctorRole->syncPermissions([
            // Modern Enum permissions
            AppPermission::ACCESS_DOCTOR_DASHBOARD->value,
            AppPermission::VIEW_DOCTOR_SCHEDULE->value,
            AppPermission::MANAGE_DOCTOR_SCHEDULE->value,
            AppPermission::VIEW_PATIENTS->value,
            AppPermission::VIEW_APPOINTMENTS->value,
            AppPermission::VIEW_MEDICAL_RECORDS->value,
            AppPermission::CREATE_MEDICAL_RECORDS->value,
            AppPermission::EDIT_MEDICAL_RECORDS->value,
            AppPermission::DOWNLOAD_MEDICAL_REPORTS->value,
            AppPermission::CHAT_DIRECT->value,
            // Legacy aliases
            'access_doctor_dashboard',
            'view_doctor_schedule',
            'manage_doctor_schedule',
            'view_patients',
            'view_appointments',
            'view_medical_records',
            'create_medical_records',
            'edit_medical_records',
            'download_medical_reports',
            'chat_direct',
        ]);

        // 5. HR Role
        $hrRole = Role::firstOrCreate(['name' => UserRole::HR->value, 'guard_name' => 'web']);
        $hrRole->syncPermissions([
            // Modern Enum permissions
            AppPermission::ACCESS_HR_DASHBOARD->value,
            AppPermission::MANAGE_DOCTORS->value,
            AppPermission::MANAGE_HR_STAFF->value,
            AppPermission::MANAGE_PATIENTS->value,
            AppPermission::VIEW_PATIENTS->value,
            AppPermission::VIEW_APPOINTMENTS->value,
            AppPermission::BOOK_APPOINTMENTS->value,
            AppPermission::RESCHEDULE_APPOINTMENTS->value,
            AppPermission::CANCEL_APPOINTMENTS->value,
            AppPermission::MANAGE_INVOICES->value,
            AppPermission::VIEW_INVOICES->value,
            AppPermission::PROCESS_PAYMENTS->value,
            // Legacy aliases
            'access_hr_dashboard',
            'manage_doctors',
            'manage_hr_staff',
            'manage_patients',
            'view_patients',
            'view_appointments',
            'book_appointments',
            'reschedule_appointments',
            'cancel_appointments',
            'manage_invoices',
            'view_invoices',
            'process_payments',
        ]);

        // 6. Patient Role
        $patientRole = Role::firstOrCreate(['name' => UserRole::PATIENT->value, 'guard_name' => 'web']);
        $patientRole->syncPermissions([
            // Modern Enum permissions
            AppPermission::ACCESS_PATIENT_DASHBOARD->value,
            AppPermission::BOOK_APPOINTMENTS->value,
            AppPermission::CANCEL_APPOINTMENTS->value,
            AppPermission::VIEW_APPOINTMENTS->value,
            AppPermission::VIEW_MEDICAL_RECORDS->value,
            AppPermission::DOWNLOAD_MEDICAL_REPORTS->value,
            AppPermission::VIEW_INVOICES->value,
            AppPermission::PROCESS_PAYMENTS->value,
            AppPermission::CHAT_DIRECT->value,
            // Legacy aliases
            'access_patient_dashboard',
            'book_appointments',
            'cancel_appointments',
            'view_appointments',
            'view_medical_records',
            'download_medical_reports',
            'view_invoices',
            'process_payments',
            'chat_direct',
        ]);
    }
}
