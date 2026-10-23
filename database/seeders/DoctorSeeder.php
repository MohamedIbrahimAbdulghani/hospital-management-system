<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctorsData = [
            [
                'name' => 'د. محمد يوسف',
                'name_en' => 'Dr. Mohamed Youssef',
                'email' => 'doctor@hospital.com',
                'password' => '123',
                'specialization_en' => 'Cardiology & Cardiac Surgery',
                'title' => 'استشاري أول أمراض القلب',
                'bio' => 'استشاري أمراض القلب والأوعية الدموية بخبرة تزيد عن 15 عاماً.',
                'experience_years' => 15,
                'consultation_fee' => 300.00,
                'rating' => 5.00,
                'avatar' => 'Dashboard/img/faces/1.jpg',
                'license_number' => 'DOC-9982',
                'sort_order' => 1,
            ],
            [
                'name' => 'د. أحمد مصطفى الكردي',
                'name_en' => 'Dr. Ahmed Mustafa',
                'email' => 'dr.ahmed@hospital.com',
                'specialization_en' => 'Cardiology & Cardiac Surgery',
                'title' => 'استشاري أول جراحة القلب والأوعية الدموية',
                'bio' => 'استشاري جراحة القلب والأوعية الدموية، زميل الكلية الملكية للجراحين في إنجلترا، خبير القسطرة التداخلية وتبديل الصمامات.',
                'experience_years' => 18,
                'consultation_fee' => 450.00,
                'rating' => 4.95,
                'avatar' => 'Dashboard/img/faces/1.jpg',
                'sort_order' => 1,
            ],
            [
                'name' => 'د. سارة خالد المنصوري',
                'name_en' => 'Dr. Sara Al-Mansoor',
                'email' => 'dr.sara@hospital.com',
                'specialization_en' => 'Ophthalmology & LASIK',
                'title' => 'استشارية طب وجراحة العيون والليزك',
                'bio' => 'استشارية جراحات القرنية وتصحيح عيوب الإبصار بالفيمتو-ليزك وزمالة البورد الأوروبي لطب العيون.',
                'experience_years' => 14,
                'consultation_fee' => 380.00,
                'rating' => 4.90,
                'avatar' => 'Dashboard/img/faces/2.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => 'د. محمود حسن الهواري',
                'name_en' => 'Dr. Mahmoud El-Hawary',
                'email' => 'dr.mahmoud@hospital.com',
                'specialization_en' => 'Orthopedics & Spine Center',
                'title' => 'استشاري جراحة العظام والمفاصل والعمود الفقري',
                'bio' => 'متخصص في تبديل المفاصل الصناعية بالتقنية الروبوتية وعلاج الكسور المعقدة وإصابات الرباط الصليبي.',
                'experience_years' => 20,
                'consultation_fee' => 500.00,
                'rating' => 4.98,
                'avatar' => 'Dashboard/img/faces/3.jpg',
                'sort_order' => 3,
            ],
            [
                'name' => 'د. منى عبد الرحمن زكي',
                'name_en' => 'Dr. Mona Abdulrahman',
                'email' => 'dr.mona@hospital.com',
                'specialization_en' => 'Pediatrics & NICU',
                'title' => 'استشارية طب الأطفال وحديثي الولادة',
                'bio' => 'رئيسة وحدة المبتسرين والعناية الفائقة لحديثي الولادة، البورد الأمريكي في طب الأطفال والرعاية الحرجة.',
                'experience_years' => 16,
                'consultation_fee' => 350.00,
                'rating' => 4.88,
                'avatar' => 'Dashboard/img/faces/4.jpg',
                'sort_order' => 4,
            ],
            [
                'name' => 'د. كريم عبد العزيز الشناوي',
                'name_en' => 'Dr. Karim El-Shennawy',
                'email' => 'dr.karim@hospital.com',
                'specialization_en' => 'Neurology & Neurosurgery',
                'title' => 'استشاري جراحة المخ والأعصاب والميكروسكوب',
                'bio' => 'عضو الجمعية الدولية لجراحة المخ والأعصاب، رائد عمليات استئصال الأورام الدقيقة تحت المراقبة العصبية اللحظية.',
                'experience_years' => 19,
                'consultation_fee' => 550.00,
                'rating' => 4.96,
                'avatar' => 'Dashboard/img/faces/5.jpg',
                'sort_order' => 5,
            ],
            [
                'name' => 'د. رانيا إبراهيم الدسوقي',
                'name_en' => 'Dr. Rania El-Desouky',
                'email' => 'dr.rania@hospital.com',
                'specialization_en' => 'Dermatology & Aesthetic Care',
                'title' => 'استشارية الأمراض الجلدية والعلاج بالليزر',
                'bio' => 'خبرة واسعة في استخدام تقنيات الفراكشنال ليزر وحقن الميزوثيرابي وتجديد نضارة البشرة وعلاج الحالات المستعصية.',
                'experience_years' => 12,
                'consultation_fee' => 320.00,
                'rating' => 4.85,
                'avatar' => 'Dashboard/img/faces/6.jpg',
                'sort_order' => 6,
            ],
            [
                'name' => 'د. طارق سامي الفقي',
                'name_en' => 'Dr. Tarek El-Feqy',
                'email' => 'dr.tarek@hospital.com',
                'specialization_en' => 'General & Laparoscopic Surgery',
                'title' => 'استشاري الجراحة العامة وجراحات السمنة بالمناظير',
                'bio' => 'عضو الفيدرالية الدولية لجراحة السمنة ومناظير الجهاز الهضمي، أجرى أكثر من 3000 عملية ناجحة بالمناظير المتطورة.',
                'experience_years' => 17,
                'consultation_fee' => 420.00,
                'rating' => 4.92,
                'avatar' => 'Dashboard/img/faces/7.jpg',
                'sort_order' => 7,
            ],
            [
                'name' => 'د. نهى فاروق الباز',
                'name_en' => 'Dr. Noha El-Baz',
                'email' => 'dr.noha@hospital.com',
                'specialization_en' => 'Obstetrics, Gynecology & IVF',
                'title' => 'استشارية النساء والتوليد وعلاج العقم وأطفال الأنابيب',
                'bio' => 'متخصصة في متابعة حالات الحمل الحرجة، الولادات الطبيعية بدون ألم، وتقنيات الإخصاب المساعد المجهري الحديثة.',
                'experience_years' => 15,
                'consultation_fee' => 400.00,
                'rating' => 4.94,
                'avatar' => 'Dashboard/img/faces/8.jpg',
                'sort_order' => 8,
            ],
        ];

        foreach ($doctorsData as $doc) {
            $user = User::updateOrCreate(
                ['email' => $doc['email']],
                [
                    'name' => $doc['name'],
                    'password' => Hash::make($doc['password'] ?? '123'),
                    'role' => 'doctor',
                    'is_active' => true,
                    'avatar' => $doc['avatar'],
                ]
            );

            // Assign role if spatie/permission is used
            if (method_exists($user, 'assignRole')) {
                try {
                    $user->assignRole('doctor');
                } catch (\Throwable $e) {
                    // Ignore if role already assigned or missing
                }
            }

            $specialization = Specialization::where('name_en', $doc['specialization_en'])->first()
                ?? Specialization::first();

            Doctor::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'specialization_id' => $specialization?->id,
                    'name_en' => $doc['name_en'],
                    'license_number' => $doc['license_number'] ?? ('DOC-' . rand(1000, 9999)),
                    'title' => $doc['title'],
                    'bio' => $doc['bio'],
                    'experience_years' => $doc['experience_years'],
                    'consultation_fee' => $doc['consultation_fee'],
                    'rating' => $doc['rating'],
                    'is_available' => true,
                    'appointments_per_day' => 20,
                    'sort_order' => $doc['sort_order'],
                ]
            );
        }
    }
}
