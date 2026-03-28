<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Appointment;

Broadcast::channel('room.{appointment_id}', function ($user, $appointment_id) {
    $appointment = Appointment::find($appointment_id);
    
    if (!$appointment) return false;

    // Si on est le patient concerné
    if ($user->role === 'patient' && $user->patient->id === $appointment->patient_id) {
        return ['id' => $user->id, 'name' => $user->name, 'type' => 'patient'];
    }
    
    // Si on est le docteur concerné
    if ($user->role === 'professional' && $user->professional->id === $appointment->professional_id) {
        return ['id' => $user->id, 'name' => 'Dr. '.$user->name, 'type' => 'professional'];
    }

    return false; // Interdit aux autres !
});
