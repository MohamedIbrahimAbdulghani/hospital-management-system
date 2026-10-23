<?php

namespace Database\Seeders;

use App\Models\HrStaff;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HrStaffSeeder extends Seeder
{
    /**
     * Run the database seeds for HR Staff.
     */
    public function run(): void
    {
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
    }
}
