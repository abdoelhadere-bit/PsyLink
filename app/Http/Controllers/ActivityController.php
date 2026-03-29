<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use App\Models\Participation;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function store(StoreActivityRequest $request)
    {
        $association = auth()->user()->association;

        if (!$association) {
            return back()->withErrors(['error' => 'Votre profil d\'association est introuvable.']);
        }

        Activity::create([
            'association_id'   => $association->id,
            'title'            => $request->title,
            'description'      => $request->description,
            'type'             => $request->type,
            'scheduled_at'     => $request->scheduled_at,
            'max_participants' => $request->max_participants,
        ]);

        return redirect()->route('dashboard')->with('success', 'Webinaire créé avec succès !');
    }

    public function destroy(Activity $activity)
    {
        $this->authorize('delete', $activity);

        $validatedCount = $activity->participations()->where('is_validated', true)->count();
        if ($validatedCount > 0) {
            return back()->withErrors([
                'error' => "Impossible de supprimer : {$validatedCount} participant(s) sont déjà confirmés."
            ]);
        }

        $activity->participations()->delete();
        $activity->delete();

        return redirect()->route('dashboard')->with('success', 'Webinaire supprimé.');
    }

    /**
     * Un patient demande à rejoindre un webinaire.
     */
    public function join(Activity $activity)
    {
        $this->authorize('join', $activity);

        if ($activity->scheduled_at < now()) {
            return back()->withErrors(['error' => 'Ce webinaire est déjà terminé.']);
        }

        $patient = auth()->user()->patient;

        Participation::create([
            'patient_id'   => $patient->id,
            'activity_id'  => $activity->id,
            'status'       => 'pending',
            'is_validated' => false,
        ]);

        return back()->with('success', 'Votre demande de participation a été envoyée à l\'association !');
    }

    public function validateParticipation(Participation $participation, Request $request)
    {
        $activity = $participation->activity;
        $this->authorize('manageParticipations', $activity);

        $action = $request->input('action'); // 'accept' ou 'reject'

        if ($action === 'accept') {
            // Cas 4 : La capacité maximale est atteinte juste avant la validation
            if ($activity->isFull()) {
                return back()->withErrors(['error' => 'Impossible de valider : le webinaire est complet.']);
            }

            $participation->update(['status' => 'accepted', 'is_validated' => true]);

            // Cas 5 : Le webinaire offre des crédits → les ajouter au portefeuille du patient
            if ($activity->free_sessions_earned > 0) {
                $participation->patient->increment('credits', $activity->free_sessions_earned);
            }

            return back()->with('success', 'Participation acceptée !');

        } elseif ($action === 'reject') {
            $participation->update(['status' => 'rejected', 'is_validated' => false]);
            return back()->with('success', 'Participation refusée.');
        }

        return back()->withErrors(['error' => 'Action non reconnue.']);
    }
}
