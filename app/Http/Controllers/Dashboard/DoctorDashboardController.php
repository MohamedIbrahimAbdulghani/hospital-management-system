<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DoctorDashboardController extends Controller
{
    /**
     * Display Doctor Dashboard
     */
    public function index(): View
    {
        $doctor = Auth::user()->doctor;

        return view('Dashboard.Doctor.dashboard', compact('doctor'));
    }
}
