<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title_ar' => 'العيادات الخارجية التخصصية',
                'title_en' => 'Specialist Outpatient Clinics',
                'description_ar' => 'حجز مسبق مع كبار الاستشاريين في كافة التخصصات الدقيقة مع تنظيم ذكي للمواعيد وتقليل فترات الانتظار.',
                'description_en' => 'Seamless consultations with renowned senior consultants across medical subspecialties with zero queues.',
                'icon' => 'fa-calendar-check',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title_ar' => 'المختبرات والتحاليل الفورية',
                'title_en' => 'Point-of-Care Laboratory',
                'description_ar' => 'فحوصات مخبرية وجينية دقيقة تصدر نتائجها رقمياً في ملف المريض فور اعتمادها مع تنبيه فوري.',
                'description_en' => 'Accredited pathology and automated molecular diagnostics publishing results directly to your digital record.',
                'icon' => 'fa-vial-circle-check',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title_ar' => 'العناية المركزة ICU و CCU',
                'title_en' => 'Intensive & Critical Care',
                'description_ar' => 'أسرّة مجهزة بأحدث أجهزة دعم ومراقبة المؤشرات الحيوية تحت إشراف أطباء العناية الحرجة على مدار الساعة.',
                'description_en' => 'State-of-the-art hemodynamic monitoring and advanced life support led by 24/7 dedicated intensivists.',
                'icon' => 'fa-bed-pulse',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title_ar' => 'الأشعة والتصوير التشخيصي الرقمي',
                'title_en' => 'Diagnostic Imaging & Radiology',
                'description_ar' => 'أجهزة رنين مغناطيسي 3T وأشعة مقطعية عالية السرعة وموجات فوق صوتية لتشخيص أدق التفاصيل بأمان.',
                'description_en' => 'Ultra-high-field 3T MRI, low-dose multi-slice CT scans, and advanced 4D ultrasound imaging.',
                'icon' => 'fa-x-ray',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title_ar' => 'جراحة اليوم الواحد والمناظير',
                'title_en' => 'Day Surgery & Laparoscopy',
                'description_ar' => 'عمليات جراحية دقيقة بأحدث تقنيات المناظير تتيح للمريض التعافي ومغادرة المستشفى في نفس اليوم بأمان.',
                'description_en' => 'Minimally invasive laparoscopic and robotic surgical interventions enabling safe same-day recovery.',
                'icon' => 'fa-hospital-user',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title_ar' => 'طوارئ وإسعاف القلب (24/7)',
                'title_en' => 'Emergency & Trauma Care (24/7)',
                'description_ar' => 'استجابة فائقة السرعة للحوادث والأزمات القلبية مع قسطرة طارئة وأسطول سيارات إسعاف مجهزة بأحدث المعدات.',
                'description_en' => 'Instant trauma triage, rapid door-to-balloon cardiac resuscitation suites, and fully equipped mobile ICU units.',
                'icon' => 'fa-truck-medical',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(
                ['title_en' => $service['title_en']],
                $service
            );
        }
    }
}
