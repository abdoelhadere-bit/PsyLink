<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class PatientDashboardController extends Controller
{
    public function __invoke()
    {
        $appointments = Appointment::with('professional.user')
            ->where('patient_id', auth()->user()->patient->id)
            ->orderByRaw("CASE 
                WHEN status = 'in_progress' THEN 1 
                WHEN status = 'waiting_payment' THEN 2 
                WHEN status = 'paid' OR status = 'accepted' THEN 3
                WHEN status = 'pending' THEN 4
                WHEN status = 'completed' THEN 5
                ELSE 6 
            END ASC")
            ->orderBy('scheduled_at', 'asc')
            ->get();
        $myActivities = auth()->user()->patient->activities()
                        ->withPivot('status', 'is_validated', 'created_at')
                        ->orderByRaw("CASE 
                            WHEN participations.status = 'accepted' THEN 1 
                            WHEN participations.status = 'pending' THEN 2 
                            WHEN participations.status = 'attended' THEN 3
                            ELSE 4 
                        END ASC")
                        ->orderByDesc('scheduled_at')
                        ->get();
        
        return view('dashboard.patient', compact('appointments', 'myActivities'));
    }
}
