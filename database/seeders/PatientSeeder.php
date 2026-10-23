<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds for Patients.
     */
    public function run(): void
    {
        
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
