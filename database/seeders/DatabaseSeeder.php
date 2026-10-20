<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\HrStaff;
use App\Models\Patient;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles and Permissions
        $this->call(RolesAndPermissionsSeeder::class);

        // 2. Medical Specializations
        $this->call(SpecializationSeeder::class);

        // 3. Super Admin user
        $admin = User::firstOrCreate(
            ['email' => 'mohamedibrahimabdulghani@gmail.com'],
            [
                'name' => 'Mohamed Ibrahim Abdulghani',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'is_active' => true,
                'must_change_password' => false,
                'email_verified_at' => now(),
            ]
        );
        if (! $admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // 4. Demo Doctor (Dr. Mohamed Youssef)
        $firstSpec = Specialization::first();
        $doctorUser = User::firstOrCreate(
            ['email' => 'doctor@hospital.com'],
            [
                'name' => 'د. محمد يوسف',
                'password' => Hash::make('123'),
                'role' => 'doctor',
                'is_active' => true,
                'must_change_password' => false,
                'email_verified_at' => now(),
            ]
        );
        if (! $doctorUser->hasRole('doctor')) {
            $doctorUser->assignRole('doctor');
        }
        Doctor::firstOrCreate(
            ['user_id' => $doctorUser->id],
            [
                'specialization_id' => $firstSpec?->id,
                'license_number' => 'DOC-9982',
                'title' => 'استشاري أول',
                'bio' => 'استشاري أمراض القلب والأوعية الدموية بخبرة تزيد عن 15 عاماً.',
                'experience_years' => 15,
                'consultation_fee' => 300.00,
                'rating' => 5.00,
                'is_available' => true,
                'appointments_per_day' => 20,
            ]
        );

        // 5. Demo HR Staff (Ayman Saeed)
        $hrUser = User::firstOrCreate(
            ['email' => 'hr@hospital.com'],
            [
                'name' => 'أيمن سعيد (مسؤول HR)',
                'password' => Hash::make('123'),
                'role' => 'hr',
                'is_active' => true,
                'must_change_password' => false,
                'email_verified_at' => now(),
            ]
        );
        if (! $hrUser->hasRole('hr')) {
            $hrUser->assignRole('hr');
        }
        HrStaff::firstOrCreate(
            ['user_id' => $hrUser->id],
            [
                'employee_id' => 'HR-1001',
                'department' => 'الموارد البشرية والاستقبال',
                'job_title' => 'مدير شؤون الموظفين والمرضى',
                'hire_date' => now()->subYears(2),
            ]
        );

        // 6. Demo Patient (Mahmoud Hassan)
        $patientUser = User::firstOrCreate(
            ['email' => 'patient@hospital.com'],
            [
                'name' => 'محمود حسن (مريض)',
                'password' => Hash::make('123'),
                'role' => 'patient',
                'is_active' => true,
                'must_change_password' => false,
                'email_verified_at' => now(),
            ]
        );
        if (! $patientUser->hasRole('patient')) {
            $patientUser->assignRole('patient');
        }
        Patient::firstOrCreate(
            ['user_id' => $patientUser->id],
            [
                'national_id' => '29501011234567',
                'gender' => 'male',
                'date_of_birth' => '1995-01-01',
                'blood_type' => 'O+',
                'city' => 'القاهرة',
            ]
        );
    }
}
