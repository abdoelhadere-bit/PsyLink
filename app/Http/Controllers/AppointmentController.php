<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;
use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;      

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
            'duration_minutes' => 45,
            'type' => $validated['type'],
            'price' => $professional->hourly_rate,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Votre demande de rendez-vous a bien été envoyée au praticien.');
    }

    public function accept(Appointment $appointment)
    {
        Gate::authorize('accept', $appointment);
        
        if ($appointment->price > 0) {
            $appointment->update(['status' => 'waiting_payment']);
            return redirect()->route('dashboard')->with('success', 'Rendez-vous accepté. En attente du paiement du patient.');
        } else {
            $appointment->update(['status' => 'paid']);
            return redirect()->route('dashboard')->with('success', 'Rendez-vous gratuit accepté. Vous pouvez le commencer à tout moment.');
        }
    }

    public function reject(Appointment $appointment)
    {
        Gate::authorize('reject', $appointment);
        $appointment->update(['status' => 'rejected']);
        return redirect()->route('dashboard')->with('success', 'Rendez-vous refusé.');
    }

    public function start(Appointment $appointment)
    {
        Gate::authorize('start', $appointment);
        
        if($appointment->status !== 'paid') {
            return redirect()->route('dashboard')->with('error', 'Vous ne pouvez pas commencer une séance non payée.');
        }

        $scheduledAt = Carbon::parse($appointment->scheduled_at);
        $allowedStartTime = $scheduledAt->copy()->subMinutes(15);
        
        if (now()->isBefore($allowedStartTime)) {
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

        $user = auth()->user();
        if ($user->role === 'patient' && ($user->patient === null || $user->patient->id !== $appointment->patient_id)) {
            abort(403, 'Accès refusé à cette salle.');
        }
        if ($user->role === 'professional' && ($user->professional === null || $user->professional->id !== $appointment->professional_id)) {
            abort(403, 'Accès refusé à cette salle.');
        }

        return view('appointments.room', compact('appointment'));
    }
}
