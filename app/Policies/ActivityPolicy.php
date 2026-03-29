<?php

namespace App\Policies;

use App\Models\Activity;
use App\Models\User;

class ActivityPolicy
{
    /**
     * Seul un utilisateur avec le rôle "association" peut créer un webinaire.
     */
    public function create(User $user): bool
    {
        return $user->role === 'association' && $user->association !== null;
    }

    /**
     * Seule l'Association propriétaire de l'activité peut la supprimer.
     */
    public function delete(User $user, Activity $activity): bool
    {
        return $user->role === 'association'
            && $user->association?->id === $activity->association_id;
    }

    /**
     * Seule l'Association propriétaire peut valider/gérer les participations.
     */
    public function manageParticipations(User $user, Activity $activity): bool
    {
        return $user->role === 'association'
            && $user->association?->id === $activity->association_id;
    }

    /**
     * Un patient peut demander à rejoindre un webinaire s'il n'est pas complet.
     */
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
