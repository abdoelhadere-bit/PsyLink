<?php

namespace App\Policies;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppointmentPolicy
{

    public function accept(User $user, Appointment $appointment)
    {
        return $user->role === 'professional' && $appointment->professional_id == $user->professional->id;
    }

    public function reject(User $user, Appointment $appointment)
    {
        return $user->role === 'professional' && $appointment->professional_id == $user->professional->id;
    }

    public function start(User $user, Appointment $appointment)
    {
        return $user->role === 'professional' && $appointment->professional_id == $user->professional->id;
    }

    public function complete(User $user, Appointment $appointment)
    {
        return $user->role === 'professional' && $appointment->professional_id == $user->professional->id;
    }

    public function viewRoom(User $user, Appointment $appointment)
    {
        if ($user->role === 'patient') {
            return $user->patient !== null && $user->patient->id === $appointment->patient_id;
        }

        if ($user->role === 'professional') {
            return $user->professional !== null && $user->professional->id === $appointment->professional_id;
        }

        return false;
    }

    public function checkout(User $user, Appointment $appointment)
    {
        return $user->role === 'patient' && $user->patient && $user->patient->id === $appointment->patient_id;
    }
}
