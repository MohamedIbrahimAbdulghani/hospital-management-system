<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSettingsController extends Controller
{
    /**
     * Show site settings form for Admin.
     */
    public function index(): View
    {
        $settings = [
            'emergency_phone' => SiteSetting::get('emergency_phone', '19999'),
            'hotline_phone' => SiteSetting::get('hotline_phone', '16000'),
            'hospital_address_ar' => SiteSetting::get('hospital_address_ar', 'المدينة الطبية - طريق الملك فهد'),
            'hospital_address_en' => SiteSetting::get('hospital_address_en', 'Medical City - King Fahd Road'),
            'hospital_email' => SiteSetting::get('hospital_email', 'support@hospital.com'),
        ];

        return view('Dashboard.Admin.settings', compact('settings'));
    }

    /**
     * Update site settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'emergency_phone' => ['required', 'string', 'max:30'],
            'hotline_phone' => ['required', 'string', 'max:30'],
            'hospital_address_ar' => ['nullable', 'string', 'max:255'],
            'hospital_address_en' => ['nullable', 'string', 'max:255'],
            'hospital_email' => ['nullable', 'email', 'max:100'],
        ]);

        foreach ($validated as $key => $value) {
            SiteSetting::set($key, $value, 'contact');
        }

        return redirect()->back()->with('status', app()->getLocale() === 'ar'
            ? 'تم حفظ وتحديث إعدادات أرقام الطوارئ والموقع بنجاح.'
            : 'Site emergency contacts and settings updated successfully.');
    }
}
