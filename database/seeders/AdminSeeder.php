<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds for Super Admin.
     */
    public function run(): void
    {
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
    }
}
