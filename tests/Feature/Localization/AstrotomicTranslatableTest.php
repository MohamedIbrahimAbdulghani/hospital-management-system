<?php

namespace Tests\Feature\Localization;

use App\Models\Doctor;
use App\Models\Section;
use App\Models\Service;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\SectionSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\DoctorSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AstrotomicTranslatableTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolesAndPermissionsSeeder::class);
        $this->seed(SectionSeeder::class);
        $this->seed(ServiceSeeder::class);
        $this->seed(DoctorSeeder::class);
    }

    public function test_section_translates_name(): void
    {
        app()->setLocale('ar');
        $sec = Section::whereTranslation('name', 'قسم أمراض وجراحة القلب', 'ar')->first();
        $this->assertNotNull($sec);
        $this->assertEquals('قسم أمراض وجراحة القلب', $sec->name);

        app()->setLocale('en');
        $this->assertEquals('Cardiology & Cardiac Surgery', $sec->name);
    }

    public function test_service_translates_title_and_description(): void
    {
        app()->setLocale('ar');
        $service = Service::whereTranslation('title', 'العيادات الخارجية التخصصية', 'ar')->first();
        $this->assertNotNull($service);
        $this->assertEquals('العيادات الخارجية التخصصية', $service->title);

        app()->setLocale('en');
        $this->assertEquals('Specialist Outpatient Clinics', $service->title);
    }

    public function test_doctor_translates_name_title_and_bio(): void
    {
        app()->setLocale('ar');
        $doctor = Doctor::whereTranslation('name', 'د. محمد يوسف', 'ar')->first();
        $this->assertNotNull($doctor);
        $this->assertEquals('د. محمد يوسف', $doctor->name);
        $this->assertStringContainsString('استشاري أول أمراض القلب', $doctor->title);
        $this->assertNotEmpty($doctor->bio);

        app()->setLocale('en');
        $this->assertEquals('Dr. Mohamed Youssef', $doctor->name);
        $this->assertEquals('Senior Consultant Cardiologist', $doctor->title);
        $this->assertStringContainsString('Cardiovascular Medicine', $doctor->bio);
    }

    public function test_doctor_section_name_accessor(): void
    {
        $doctor = Doctor::with('section.translations')->first();
        $this->assertNotNull($doctor);

        app()->setLocale('ar');
        $this->assertNotEmpty($doctor->section_name);

        app()->setLocale('en');
        $this->assertNotEmpty($doctor->section_name);
    }
}
