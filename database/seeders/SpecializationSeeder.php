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
                'name_ar' => 'قسم أمراض وجراحة القلب',
                'name_en' => 'Cardiology & Cardiac Surgery',
                'icon' => 'fa-heart-pulse',
                'description' => 'قسطرة قلبية تداخلية، جراحات الصمامات، وعناية مركزة CCU فائقة التطور.',
                'description_en' => 'Interventional cardiology, heart valve surgery, and advanced CCU intensive care.',
                'sort_order' => 1,
            ],
            [
                'name_ar' => 'قسم جراحة المخ والأعصاب',
                'name_en' => 'Neurology & Neurosurgery',
                'icon' => 'fa-brain',
                'description' => 'جراحات الميكروسكوب والعمود الفقري وعلاج السكتات الدماغية والصرع.',
                'description_en' => 'Microscopic brain and spine surgery, stroke management, and epilepsy care.',
                'sort_order' => 2,
            ],
            [
                'name_ar' => 'قسم طب الأطفال وحديثي الولادة',
                'name_en' => 'Pediatrics & NICU',
                'icon' => 'fa-baby',
                'description' => 'حضانات ذكية مبتسرة ورعاية شاملة للأطفال من الولادة حتى المراهقة.',
                'description_en' => 'Advanced smart neonatal incubators and comprehensive child healthcare.',
                'sort_order' => 3,
            ],
            [
                'name_ar' => 'قسم جراحة العظام والمفاصل',
                'name_en' => 'Orthopedics & Spine Center',
                'icon' => 'fa-bone',
                'description' => 'تبديل المفاصل بالروبوت، جراحات المناظير الدقيقة، وإصابات الملاعب.',
                'description_en' => 'Robotic joint replacement, arthroscopy, and sports trauma rehabilitation.',
                'sort_order' => 4,
            ],
            [
                'name_ar' => 'قسم طب وجراحة العيون والليزر',
                'name_en' => 'Ophthalmology & LASIK',
                'icon' => 'fa-eye',
                'description' => 'تصحيح الإبصار بالليزك الفيمتو، جراحات المياه البيضاء، وأمراض الشبكية.',
                'description_en' => 'Femto-LASIK vision correction, cataract microsurgery, and vitreo-retinal therapies.',
                'sort_order' => 5,
            ],
            [
                'name_ar' => 'قسم الأمراض الجلدية والتجميل',
                'name_en' => 'Dermatology & Aesthetic Care',
                'icon' => 'fa-wand-magic-sparkles',
                'description' => 'أحدث أجهزة الليزر الطبي، علاج الأمراض الجلدية المزمنة، وتجديد البشرة.',
                'description_en' => 'Medical lasers, chronic skin disease management, and anti-aging therapies.',
                'sort_order' => 6,
            ],
            [
                'name_ar' => 'قسم طب وجراحة الفم والأسنان',
                'name_en' => 'Dentistry & Maxillofacial',
                'icon' => 'fa-tooth',
                'description' => 'زراعة الأسنان الرقمية، هوليوود سمايل، وجراحات الفكين المتقدمة.',
                'description_en' => 'Digital implantology, cosmetic smile makeovers, and maxillofacial surgery.',
                'sort_order' => 7,
            ],
            [
                'name_ar' => 'قسم الباطنة العامة والجهاز الهضمي',
                'name_en' => 'Internal Medicine & Gastroenterology',
                'icon' => 'fa-lungs',
                'description' => 'مناظير الجهاز الهضمي التشخيصية والعلاجية وعلاج الأمراض الباطنية المزمنة.',
                'description_en' => 'Diagnostic and therapeutic endoscopies and management of chronic metabolic disorders.',
                'sort_order' => 8,
            ],
            [
                'name_ar' => 'قسم الجراحة العامة والمناظير',
                'name_en' => 'General & Laparoscopic Surgery',
                'icon' => 'fa-scissors',
                'description' => 'جراحات اليوم الواحد واستئصال الأورام بأحدث مناظير التجويف البطني ثلاثية الأبعاد.',
                'description_en' => 'Advanced 3D laparoscopic interventions, oncology surgery, and day surgery suites.',
                'sort_order' => 9,
            ],
            [
                'name_ar' => 'قسم النساء والتوليد وعلاج العقم',
                'name_en' => 'Obstetrics, Gynecology & IVF',
                'icon' => 'fa-heart',
                'description' => 'متابعة الحمل الحرج، ولادات قيصرية وطبيعية بدون ألم، ومراكز علاج العقم المتطورة.',
                'description_en' => 'High-risk pregnancy management, painless childbirth, and assisted reproduction centers.',
                'sort_order' => 10,
            ],
        ];

        foreach ($specializations as $idx => $item) {
            $existing = Specialization::find($idx + 1);
            if ($existing) {
                $existing->update($item + ['is_active' => true]);
            } else {
                Specialization::create($item + ['is_active' => true]);
            }
        }

        Specialization::where('id', '>', count($specializations))->delete();
    }
}
