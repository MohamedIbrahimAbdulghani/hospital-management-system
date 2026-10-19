<?php

namespace Database\Seeders;

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

        // List of all permissions
        $permissions = [
            // Admin / System
            'access_admin_dashboard',
            'manage_users',
            'manage_roles_permissions',
            'manage_specializations',
            'view_system_logs',

            // Doctor management
            'access_doctor_dashboard',
            'manage_doctors',
            'view_doctor_schedule',
            'manage_doctor_schedule',

            // Patient management
            'access_patient_dashboard',
            'manage_patients',
            'view_patients',

            // HR management
            'access_hr_dashboard',
            'manage_hr_staff',

            // Appointments
            'view_appointments',
            'book_appointments',
            'reschedule_appointments',
            'cancel_appointments',

            // Medical Records
            'view_medical_records',
            'create_medical_records',
            'edit_medical_records',
            'download_medical_reports',

            // Billing / Invoices / Payments
            'manage_invoices',
            'view_invoices',
            'process_payments',

            // Communication / Chat
            'chat_direct',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // 1. Admin Role (Has all permissions)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // 2. Doctor Role
        $doctorRole = Role::firstOrCreate(['name' => 'doctor', 'guard_name' => 'web']);
        $doctorRole->syncPermissions([
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

        // 3. HR Role
        $hrRole = Role::firstOrCreate(['name' => 'hr', 'guard_name' => 'web']);
        $hrRole->syncPermissions([
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

        // 4. Patient Role
        $patientRole = Role::firstOrCreate(['name' => 'patient', 'guard_name' => 'web']);
        $patientRole->syncPermissions([
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
