<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display Admin Dashboard statistics and overview
     */
    public function index(): View
    {
        $stats = [
            'doctors_count'         => Doctor::count(),
            'patients_count'        => Patient::count(),
            'specializations_count' => Specialization::count(),
            'staff_count'           => User::whereIn('role', ['admin', 'hr'])->count(),
        ];

        return view('Dashboard.Admin.dashboard', compact('stats'));
    }
}
