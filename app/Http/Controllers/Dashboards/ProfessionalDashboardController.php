<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class ProfessionalDashboardController extends Controller
{
    public function __invoke()
    {
        $appointments = Appointment::with('patient.user')->where('professional_id', auth()->user()->professional->id)->get();
        
        if (auth()->user()->professional->is_valid) {
            return view('dashboard.professional', compact('appointments'));
        }

        return view('dashboard.pending');
    }
}
