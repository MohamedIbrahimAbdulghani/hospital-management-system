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
                'icon' => 'fa-heart-pulse',
                'sort_order' => 1,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم أمراض وجراحة القلب',
                    'description' => 'قسطرة قلبية تداخلية، جراحات الصمامات، وعناية مركزة CCU فائقة التطور.',
                ],
                'en' => [
                    'name' => 'Cardiology & Cardiac Surgery',
                    'description' => 'Interventional cardiology, heart valve surgery, and advanced CCU intensive care.',
                ],
            ],
            [
                'icon' => 'fa-brain',
                'sort_order' => 2,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم جراحة المخ والأعصاب',
                    'description' => 'جراحات الميكروسكوب والعمود الفقري وعلاج السكتات الدماغية والصرع.',
                ],
                'en' => [
                    'name' => 'Neurology & Neurosurgery',
                    'description' => 'Microscopic brain and spine surgery, stroke management, and epilepsy care.',
                ],
            ],
            [
                'icon' => 'fa-baby',
                'sort_order' => 3,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم طب الأطفال وحديثي الولادة',
                    'description' => 'حضانات ذكية مبتسرة ورعاية شاملة للأطفال من الولادة حتى المراهقة.',
                ],
                'en' => [
                    'name' => 'Pediatrics & NICU',
                    'description' => 'Advanced smart neonatal incubators and comprehensive child healthcare.',
                ],
            ],
            [
                'icon' => 'fa-bone',
                'sort_order' => 4,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم جراحة العظام والمفاصل',
                    'description' => 'تبديل المفاصل بالروبوت، جراحات المناظير الدقيقة، وإصابات الملاعب.',
                ],
                'en' => [
                    'name' => 'Orthopedics & Spine Center',
                    'description' => 'Robotic joint replacement, arthroscopy, and sports trauma rehabilitation.',
                ],
            ],
            [
                'icon' => 'fa-eye',
                'sort_order' => 5,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم طب وجراحة العيون والليزر',
                    'description' => 'تصحيح الإبصار بالليزك الفيمتو، جراحات المياه البيضاء، وأمراض الشبكية.',
                ],
                'en' => [
                    'name' => 'Ophthalmology & LASIK',
                    'description' => 'Femto-LASIK vision correction, cataract microsurgery, and vitreo-retinal therapies.',
                ],
            ],
            [
                'icon' => 'fa-wand-magic-sparkles',
                'sort_order' => 6,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم الأمراض الجلدية والتجميل',
                    'description' => 'أحدث أجهزة الليزر الطبي، علاج الأمراض الجلدية المزمنة، وتجديد البشرة.',
                ],
                'en' => [
                    'name' => 'Dermatology & Aesthetic Care',
                    'description' => 'Medical lasers, chronic skin disease management, and anti-aging therapies.',
                ],
            ],
            [
                'icon' => 'fa-tooth',
                'sort_order' => 7,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم طب وجراحة الفم والأسنان',
                    'description' => 'زراعة الأسنان الرقمية، هوليوود سمايل، وجراحات الفكين المتقدمة.',
                ],
                'en' => [
                    'name' => 'Dentistry & Maxillofacial',
                    'description' => 'Digital implantology, cosmetic smile makeovers, and maxillofacial surgery.',
                ],
            ],
            [
                'icon' => 'fa-lungs',
                'sort_order' => 8,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم الباطنة العامة والجهاز الهضمي',
                    'description' => 'مناظير الجهاز الهضمي التشخيصية والعلاجية وعلاج الأمراض الباطنية المزمنة.',
                ],
                'en' => [
                    'name' => 'Internal Medicine & Gastroenterology',
                    'description' => 'Diagnostic and therapeutic endoscopies and management of chronic metabolic disorders.',
                ],
            ],
            [
                'icon' => 'fa-scissors',
                'sort_order' => 9,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم الجراحة العامة والمناظير',
                    'description' => 'جراحات اليوم الواحد واستئصال الأورام بأحدث مناظير التجويف البطني ثلاثية الأبعاد.',
                ],
                'en' => [
                    'name' => 'General & Laparoscopic Surgery',
                    'description' => 'Advanced 3D laparoscopic interventions, oncology surgery, and day surgery suites.',
                ],
            ],
            [
                'icon' => 'fa-heart',
                'sort_order' => 10,
                'is_active' => true,
                'ar' => [
                    'name' => 'قسم النساء والتوليد وعلاج العقم',
                    'description' => 'متابعة الحمل الحرج، ولادات قيصرية وطبيعية بدون ألم، ومراكز علاج العقم المتطورة.',
                ],
                'en' => [
                    'name' => 'Obstetrics, Gynecology & IVF',
                    'description' => 'High-risk pregnancy management, painless childbirth, and assisted reproduction centers.',
                ],
            ],
        ];

        foreach ($specializations as $idx => $item) {
            $existing = Specialization::find($idx + 1);
            if ($existing) {
                $existing->update($item);
            } else {
                Specialization::create($item);
            }
        }

        Specialization::where('id', '>', count($specializations))->delete();
    }
}
