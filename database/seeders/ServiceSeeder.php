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
                'icon' => 'fa-calendar-check',
                'sort_order' => 1,
                'is_active' => true,
                'ar' => [
                    'title' => 'العيادات الخارجية التخصصية',
                    'description' => 'حجز مسبق مع كبار الاستشاريين في كافة التخصصات الدقيقة مع تنظيم ذكي للمواعيد وتقليل فترات الانتظار.',
                ],
                'en' => [
                    'title' => 'Specialist Outpatient Clinics',
                    'description' => 'Seamless consultations with renowned senior consultants across medical subspecialties with zero queues.',
                ],
            ],
            [
                'icon' => 'fa-vial-circle-check',
                'sort_order' => 2,
                'is_active' => true,
                'ar' => [
                    'title' => 'المختبرات والتحاليل الفورية',
                    'description' => 'فحوصات مخبرية وجينية دقيقة تصدر نتائجها رقمياً في ملف المريض فور اعتمادها مع تنبيه فوري.',
                ],
                'en' => [
                    'title' => 'Point-of-Care Laboratory',
                    'description' => 'Accredited pathology and automated molecular diagnostics publishing results directly to your digital record.',
                ],
            ],
            [
                'icon' => 'fa-bed-pulse',
                'sort_order' => 3,
                'is_active' => true,
                'ar' => [
                    'title' => 'العناية المركزة ICU و CCU',
                    'description' => 'أسرّة مجهزة بأحدث أجهزة دعم ومراقبة المؤشرات الحيوية تحت إشراف أطباء العناية الحرجة على مدار الساعة.',
                ],
                'en' => [
                    'title' => 'Intensive & Critical Care',
                    'description' => 'State-of-the-art hemodynamic monitoring and advanced life support led by 24/7 dedicated intensivists.',
                ],
            ],
            [
                'icon' => 'fa-x-ray',
                'sort_order' => 4,
                'is_active' => true,
                'ar' => [
                    'title' => 'الأشعة والتصوير التشخيصي الرقمي',
                    'description' => 'أجهزة رنين مغناطيسي 3T وأشعة مقطعية عالية السرعة وموجات فوق صوتية لتشخيص أدق التفاصيل بأمان.',
                ],
                'en' => [
                    'title' => 'Diagnostic Imaging & Radiology',
                    'description' => 'Ultra-high-field 3T MRI, low-dose multi-slice CT scans, and advanced 4D ultrasound imaging.',
                ],
            ],
            [
                'icon' => 'fa-hospital-user',
                'sort_order' => 5,
                'is_active' => true,
                'ar' => [
                    'title' => 'جراحة اليوم الواحد والمناظير',
                    'description' => 'عمليات جراحية دقيقة بأحدث تقنيات المناظير تتيح للمريض التعافي ومغادرة المستشفى في نفس اليوم بأمان.',
                ],
                'en' => [
                    'title' => 'Day Surgery & Laparoscopy',
                    'description' => 'Minimally invasive laparoscopic and robotic surgical interventions enabling safe same-day recovery.',
                ],
            ],
            [
                'icon' => 'fa-truck-medical',
                'sort_order' => 6,
                'is_active' => true,
                'ar' => [
                    'title' => 'طوارئ وإسعاف القلب (24/7)',
                    'description' => 'استجابة فائقة السرعة للحوادث والأزمات القلبية مع قسطرة طارئة وأسطول سيارات إسعاف مجهزة بأحدث المعدات.',
                ],
                'en' => [
                    'title' => 'Emergency & Trauma Care (24/7)',
                    'description' => 'Instant trauma triage, rapid door-to-balloon cardiac resuscitation suites, and fully equipped mobile ICU units.',
                ],
            ],
        ];

        foreach ($services as $serviceData) {
            $existing = Service::where('sort_order', $serviceData['sort_order'])->first();
            if ($existing) {
                $existing->update($serviceData);
            } else {
                Service::create($serviceData);
            }
        }
    }
}
