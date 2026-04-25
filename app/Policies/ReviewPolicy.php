<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{

    public function create(User $user, Appointment $appointment): bool
    {
        if ($user->role !== 'patient' || !$user->patient) {
            return false;
        }

        if ($appointment->patient_id !== $user->patient->id) {
            return false;
        }

        if ($appointment->status !== 'completed') {
            return false;
        }

        if ($appointment->review()->exists()) {
            return false;
        }

        return true;
    }
}
