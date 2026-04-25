<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;
use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\Services\NotificationService;


class AppointmentController extends Controller
{

    
    public function create($professional_id)
    {
        $professional = Professional::with('user')->findOrFail($professional_id);
        return view('appointments.create', compact('professional'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        $validated = $request->validated();
        if(!auth()->user()){
            return redirect()->route('dashboard')->with('error', 'Vous devez être connecté en tant que patient pour prendre rendez-vous.');
        }
        $professional = Professional::findOrFail($validated['professional_id']);

        $appointment = Appointment::create([
            'patient_id' => auth()->user()->patient->id, 
            'professional_id' => $validated['professional_id'],
            'scheduled_at' => $validated['scheduled_at'],
            'duration_minutes' => 60,
            'type' => $validated['type'],
            'price' => $professional->hourly_rate,
            'status' => 'pending',
        ]);

        // E-mail au professionnel
        $patientName = auth()->user()->name;
        $date = Carbon::parse($validated['scheduled_at'])->format('d/m/Y \u00e0 H:i');
        NotificationService::sendEmail(
            $professional->user,
            'Nouvelle demande de rendez-vous',
            "Bonjour Dr. {$professional->user->name},\n\n{$patientName} souhaite prendre rendez-vous avec vous le {$date}.\n\nConnectez-vous à votre espace pour accepter ou refuser cette demande."
        );

        return redirect()->route('dashboard')->with('success', 'Votre demande de rendez-vous a bien été envoyée au praticien.');
    }

    public function accept(Appointment $appointment)
    {
        Gate::authorize('accept', $appointment);
        
        if ($appointment->price > 0) {
            $appointment->update(['status' => 'waiting_payment']);
            // E-mail au patient : en attente paiement
            $date = Carbon::parse($appointment->scheduled_at)->format('d/m/Y \u00e0 H:i');
            NotificationService::sendEmail(
                $appointment->patient->user,
                'Votre rendez-vous a été accepté !',
                "Bonjour {$appointment->patient->user->name},\n\nVotre rendez-vous du {$date} avec Dr. {$appointment->professional->user->name} a été accepté.\n\nIl vous reste à régler la séance ({$appointment->price}€) depuis votre tableau de bord."
            );
            return redirect()->route('dashboard')->with('success', 'Rendez-vous accepté. En attente du paiement du patient.');
        } else {
            $appointment->update(['status' => 'paid']);
            NotificationService::sendEmail(
                $appointment->patient->user,
                'Rendez-vous gratuit confirmé !',
                "Bonjour {$appointment->patient->user->name},\n\nVotre rendez-vous avec Dr. {$appointment->professional->user->name} est confirmé. Il est gratuit et démarrera à l'heure prévue."
            );
            return redirect()->route('dashboard')->with('success', 'Rendez-vous gratuit accepté. Vous pouvez le commencer à tout moment.');
        }
    }

    public function reject(Appointment $appointment)
    {
        Gate::authorize('reject', $appointment);
        $appointment->update(['status' => 'rejected']);
        // E-mail au patient : refus
        NotificationService::sendEmail(
            $appointment->patient->user,
            'Votre demande de rendez-vous',
            "Bonjour {$appointment->patient->user->name},\n\nNous vous informons que Dr. {$appointment->professional->user->name} n'a pas pu accepter votre demande de rendez-vous. Vous pouvez en faire une nouvelle avec un autre praticien depuis la plateforme."
        );
        return redirect()->route('dashboard')->with('success', 'Rendez-vous refusé.');
    }

    public function start(Appointment $appointment)
    {
        Gate::authorize('start', $appointment);
        
        if($appointment->status !== 'paid') {
            return redirect()->route('dashboard')->with('error', 'Vous ne pouvez pas commencer une séance non payée.');
        }
        
        if (!$appointment->isReadyToStart()) {
            return redirect()->route('dashboard')->with('error', 'Vous ne pouvez rejoindre la salle que 15 minutes avant l\'heure prévue.');
        }

        $appointment->update(['status' => 'in_progress']);
        return redirect()->route('appointments.room', $appointment->id);
    }

    public function complete(Appointment $appointment)
    {
        Gate::authorize('complete', $appointment);
        $appointment->update(['status' => 'completed']);
        return redirect()->route('dashboard')->with('success', 'Rendez-vous terminé.');
    }

    public function room(Appointment $appointment)
    {
        if ($appointment->status !== 'in_progress' && $appointment->status !== 'paid') {
            return redirect()->route('dashboard')->with('error', 'La salle de consultation n\'est pas ouverte (Séance non payée ou terminée).');
        }

        Gate::authorize('viewRoom', $appointment);

        return view('appointments.room', compact('appointment'));
    }
}
