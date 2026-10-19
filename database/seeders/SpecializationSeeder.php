<?php

namespace Database\Seeders;

use App\Models\Specialization;
use Illuminate\Database\Seeder;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            [
                'name_ar' => 'أمراض القلب والأوعية الدموية',
                'name_en' => 'Cardiology',
                'icon' => 'heart-pulse',
                'description' => 'تشخيص وعلاج أمراض القلب والأوعية الدموية وضغط الدم.',
            ],
            [
                'name_ar' => 'طب الأطفال وحديثي الولادة',
                'name_en' => 'Pediatrics',
                'icon' => 'baby',
                'description' => 'رعاية صحة الرضع والأطفال والمراهقين ومتابعة النمو والتطعيمات.',
            ],
            [
                'name_ar' => 'جراحة العظام والمفاصل',
                'name_en' => 'Orthopedics',
                'icon' => 'bone',
                'description' => 'علاج الكسور، آلام المفاصل، العمود الفقري والإصابات الرياضية.',
            ],
            [
                'name_ar' => 'طب وجراحة العيون',
                'name_en' => 'Ophthalmology',
                'icon' => 'eye',
                'description' => 'فحص النظر، جراحات الليزك وعلاج أمراض الشبكية والقرنية.',
            ],
            [
                'name_ar' => 'الأمراض الجلدية والتجميل',
                'name_en' => 'Dermatology',
                'icon' => 'sparkles',
                'description' => 'علاج الأمراض الجلدية المزمنة وخدمات الليزر والتجميل.',
            ],
            [
                'name_ar' => 'المخ والأعصاب',
                'name_en' => 'Neurology',
                'icon' => 'brain',
                'description' => 'علاج الصداع المزمن، الصرع، السكتات الدماغية واضطرابات الأعصاب.',
            ],
            [
                'name_ar' => 'طب وجراحة الفم والأسنان',
                'name_en' => 'Dentistry',
                'icon' => 'smile',
                'description' => 'علاج وتجميل الأسنان، زراعة وتقويم الأسنان وعلاج الجذور.',
            ],
            [
                'name_ar' => 'الباطنة العامة والجهاز الهضمي',
                'name_en' => 'Internal Medicine',
                'icon' => 'activity',
                'description' => 'علاج الأمراض الباطنية المزمنة كالسكر والضغط وأمراض الكبد والجهاز الهضمي.',
            ],
            [
                'name_ar' => 'الجراحة العامة والمناظير',
                'name_en' => 'General Surgery',
                'icon' => 'scissors',
                'description' => 'إجراء العمليات الجراحية المتقدمة وجراحات المناظير الدقيقة.',
            ],
            [
                'name_ar' => 'النساء والتوليد وعلاج العقم',
                'name_en' => 'Obstetrics & Gynecology',
                'icon' => 'heart',
                'description' => 'متابعة الحمل والولادة، جراحات النساء وعلاج تأخر الإنجاب.',
            ],
        ];

        foreach ($specializations as $item) {
            Specialization::firstOrCreate(
                ['name_en' => $item['name_en']],
                $item
            );
        }
    }
}
