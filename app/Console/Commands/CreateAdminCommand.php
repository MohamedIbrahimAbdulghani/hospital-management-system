<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hms:create-admin {--name= : Admin name} {--email= : Admin email} {--password= : Admin password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Administrator account for the Hospital Management System';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('==========================================');
        $this->info('  Hospital Management System - Admin Setup ');
        $this->info('==========================================');

        $name = $this->option('name') ?: $this->ask('Enter Admin Name');
        $email = $this->option('email') ?: $this->ask('Enter Admin Email');
        $password = $this->option('password') ?: $this->secret('Enter Admin Password');

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        // Ensure role exists in Spatie
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'is_active' => true,
            'must_change_password' => false,
            'email_verified_at' => now(),
        ]);

        $user->assignRole('admin');

        $this->newLine();
        $this->info("✓ Administrator [{$user->name} <{$user->email}>] created successfully!");

        return self::SUCCESS;
    }
}
