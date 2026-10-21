<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'emergency_phone' => '19999',
            'hotline_phone' => '16000',
            'hospital_address_ar' => 'المدينة الطبية - طريق الملك فهد',
            'hospital_address_en' => 'Medical City - King Fahd Road',
            'hospital_email' => 'support@hospital.com',
        ];

        foreach ($settings as $key => $value) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'contact']
            );
        }

        SiteSetting::clearCache();
    }
}
