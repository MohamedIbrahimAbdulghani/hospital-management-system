<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\SectionTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        SectionTranslation::truncate();
        Section::truncate();
        Schema::enableForeignKeyConstraints();

        $sections = [
            [
                'ar' => ['name' => 'قسم أمراض وجراحة القلب'],
                'en' => ['name' => 'Cardiology & Cardiac Surgery'],
            ],
            [
                'ar' => ['name' => 'قسم جراحة المخ والأعصاب'],
                'en' => ['name' => 'Neurology & Neurosurgery'],
            ],
            [
                'ar' => ['name' => 'قسم طب الأطفال وحديثي الولادة'],
                'en' => ['name' => 'Pediatrics & NICU'],
            ],
            [
                'ar' => ['name' => 'قسم جراحة العظام والمفاصل'],
                'en' => ['name' => 'Orthopedics & Spine Center'],
            ],
            [
                'ar' => ['name' => 'قسم طب وجراحة العيون والليزر'],
                'en' => ['name' => 'Ophthalmology & LASIK'],
            ],
            [
                'ar' => ['name' => 'قسم الأمراض الجلدية والتجميل'],
                'en' => ['name' => 'Dermatology & Aesthetic Care'],
            ],
            [
                'ar' => ['name' => 'قسم طب وجراحة الفم والأسنان'],
                'en' => ['name' => 'Dentistry & Maxillofacial'],
            ],
            [
                'ar' => ['name' => 'قسم الباطنة العامة والجهاز الهضمي'],
                'en' => ['name' => 'Internal Medicine & Gastroenterology'],
            ],
            [
                'ar' => ['name' => 'قسم الجراحة العامة والمناظير'],
                'en' => ['name' => 'General & Laparoscopic Surgery'],
            ],
            [
                'ar' => ['name' => 'قسم النساء والتوليد وعلاج العقم'],
                'en' => ['name' => 'Obstetrics, Gynecology & IVF'],
            ],
        ];

        foreach ($sections as $item) {
            $sec = new Section();
            $sec->translateOrNew('ar')->name = $item['ar']['name'];
            $sec->translateOrNew('en')->name = $item['en']['name'];
            $sec->save();
        }
    }
}
