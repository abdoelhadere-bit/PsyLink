<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;
use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;

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
            'status' => 'en_attente',
        ]);

        return redirect()->route('dashboard')->with('success', 'Votre demande de rendez-vous a bien été envoyée au praticien.');
    }
}
