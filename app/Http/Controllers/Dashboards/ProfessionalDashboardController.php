<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class ProfessionalDashboardController extends Controller
{
    public function __invoke()
    {
        $appointments = Appointment::with('patient.user')
            ->where('professional_id', auth()->user()->professional->id)
            ->orderByRaw("CASE 
                WHEN status = 'in_progress' THEN 1 
                WHEN status = 'pending' THEN 2
                WHEN status = 'paid' OR status = 'accepted' THEN 3
                WHEN status = 'waiting_payment' THEN 4
                WHEN status = 'completed' THEN 5
                ELSE 6 
            END ASC")
            ->orderBy('scheduled_at', 'asc')
            ->get();
        
        $professional = auth()->user()->professional;

        if ($professional->is_valid) {
            // Si le profil est vide, rediriger vers le profil
            if (empty($professional->specialty) || empty($professional->bio)) {
                return redirect()->route('professional.profile.edit')
                    ->with('success', 'Votre compte a été validé ! Complétez votre profil pour apparaître dans l\'annuaire.');
            }
            return view('dashboard.professional', compact('appointments'));
        }

        return view('dashboard.pending');
    }
}
