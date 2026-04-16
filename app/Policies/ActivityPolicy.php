<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;

class ActivityPolicy
{
    
    public function create(User $user): bool
    {
        return $user->role === 'association';
    }

    public function delete(User $user, Activity $activity): bool
    {
        return $user->role === 'association'
            && $user->association?->id === $activity->association_id;
    }

   
    public function manageParticipations(User $user, Activity $activity): bool
    {
        return $user->role === 'association'
            && $user->association?->id === $activity->association_id;
    }

    
    public function join(User $user, Activity $activity): bool
    {
        if ($user->role !== 'patient') return false;

        $alreadyJoined = $activity->participations()
            ->where('patient_id', $user->patient->id)
            ->exists();
        if ($alreadyJoined) return false;

        $currentCount = $activity->participations()->where('is_validated', true)->count();
        return $currentCount < $activity->max_participants;
    }
}
