<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Specialization;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the hospital landing page.
     */
    public function index(): View
    {
        $locale = app()->getLocale();
        $isRtl = $locale === 'ar';

        // 1. Settings (Top bar & Footer)
        $settings = (object) [
            'emergency_phone' => SiteSetting::get('emergency_phone', '19999'),
            'hotline_phone' => SiteSetting::get('hotline_phone', '16000'),
            'hospital_email' => SiteSetting::get('hospital_email', 'support@hospital.com'),
            'hospital_address' => $isRtl
                ? SiteSetting::get('hospital_address_ar', 'المدينة الطبية - طريق الملك فهد')
                : SiteSetting::get('hospital_address_en', 'Medical City - King Fahd Road'),
            'hospital_address_ar' => SiteSetting::get('hospital_address_ar', 'المدينة الطبية - طريق الملك فهد'),
            'hospital_address_en' => SiteSetting::get('hospital_address_en', 'Medical City - King Fahd Road'),
        ];

        // 2. Departments (Specializations) - Active, ordered, selected columns
        $departments = Specialization::query()
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->select([
                'id',
                'name_ar',
                'name_en',
                'icon',
                'description',
                'description_en',
                'sort_order',
                'is_active',
            ])
            ->get();

        // 3. Services - Active, ordered, selected columns
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->select([
                'id',
                'title_ar',
                'title_en',
                'description_ar',
                'description_en',
                'icon',
                'sort_order',
                'is_active',
            ])
            ->get();

        // 4. Featured Doctors (8 active with user and specialization eager loaded)
        $doctors = Doctor::query()
            ->with([
                'user' => function ($query) {
                    $query->select(['id', 'name', 'avatar', 'is_active']);
                },
                'specialization' => function ($query) {
                    $query->select(['id', 'name_ar', 'name_en']);
                },
            ])
            ->where('is_available', true)
            ->whereHas('user', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('sort_order', 'asc')
            ->select([
                'id',
                'user_id',
                'specialization_id',
                'name_en',
                'title',
                'bio',
                'rating',
                'experience_years',
                'consultation_fee',
                'sort_order',
                'is_available',
            ])
            ->take(8)
            ->get();

        // 5. Dynamic Statistics
        $doctorsCount = Doctor::where('is_available', true)->count();
        $departmentsCount = Specialization::where('is_active', true)->count();

        $stats = (object) [
            'doctors_count' => $doctorsCount > 0 ? $doctorsCount : 50,
            'departments_count' => $departmentsCount > 0 ? $departmentsCount : 20,
            'experience_years' => 25,
            'satisfaction_rate' => '99.4%',
            'availability' => '24/7',
        ];

        return view('welcome', compact(
            'settings',
            'departments',
            'services',
            'doctors',
            'stats'
        ));
    }
}
