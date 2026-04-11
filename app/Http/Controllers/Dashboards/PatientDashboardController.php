<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class PatientDashboardController extends Controller
{
    public function __invoke()
    {
        $appointments = Appointment::with('professional.user')->where('patient_id', auth()->user()->patient->id)->get();
        $myActivities = auth()->user()->patient->activities()->withPivot('status', 'is_validated', 'created_at')->orderByDesc('scheduled_at')->get();
        
        return view('dashboard.patient', compact('appointments', 'myActivities'));
    }
}
