<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PatientDashboardController extends Controller
{
    /**
     * Display Patient Dashboard
     */
    public function index(): View
    {
        $patient = Auth::user()->patient;

        return view('Dashboard.Patient.dashboard', compact('patient'));
    }
}
