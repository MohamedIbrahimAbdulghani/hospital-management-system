<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\HrStaff;
use App\Models\Patient;
use Illuminate\View\View;

class HrDashboardController extends Controller
{
    /**
     * Display HR Staff Dashboard
     */
    public function index(): View
    {
        $stats = [
            'doctors_count'  => Doctor::count(),
            'patients_count' => Patient::count(),
            'hr_staff_count' => HrStaff::count(),
        ];

        return view('Dashboard.HR.dashboard', compact('stats'));
    }
}
