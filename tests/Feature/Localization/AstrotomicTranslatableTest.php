<?php

namespace Tests\Feature\Localization;

use App\Models\Doctor;
use App\Models\Service;
use App\Models\Specialization;
use Tests\TestCase;

class AstrotomicTranslatableTest extends TestCase
{
    public function test_specialization_translates_name_and_description(): void
    {
        app()->setLocale('ar');
        $spec = Specialization::whereTranslation('name', 'قسم أمراض وجراحة القلب', 'ar')->first();
        $this->assertNotNull($spec);
        $this->assertEquals('قسم أمراض وجراحة القلب', $spec->name);

        app()->setLocale('en');
        $this->assertEquals('Cardiology & Cardiac Surgery', $spec->name);
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

    public function test_doctor_specialization_name_accessor(): void
    {
        $doctor = Doctor::with('specialization.translations')->first();
        $this->assertNotNull($doctor);

        app()->setLocale('ar');
        $this->assertNotEmpty($doctor->specialization_name);

        app()->setLocale('en');
        $this->assertNotEmpty($doctor->specialization_name);
    }
}
