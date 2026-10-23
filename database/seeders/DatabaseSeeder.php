<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminSeeder::class,
            SpecializationSeeder::class,
            DoctorSeeder::class,
            HrStaffSeeder::class,
            PatientSeeder::class,
            ServiceSeeder::class,
            SiteSettingSeeder::class,
        ]);
    }
}
