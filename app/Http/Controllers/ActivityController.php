<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use App\Models\Participation;
use Illuminate\Http\Request;
use App\Policies\ActivityPolicy;
use Illuminate\Support\Facades\Gate;

class ActivityController extends Controller
{

    public function index()
    {
        $activities = Activity::with('association')->orderBy('scheduled_at', 'asc')->get();
        $userParticipations = [];

        if (auth()->check() && auth()->user()->role === 'patient') {
            $userParticipations = auth()->user()->patient->activities->pluck('pivot.status', 'id')->toArray();
        }

        return view('activities.index', compact('activities', 'userParticipations'));
    } 

    public function store(StoreActivityRequest $request)
    {
        // Gate::authorize('create');

        Activity::create([
            'association_id'       => $request->association_id,
            'title'                => $request->title,
            'description'          => $request->description,
            'type'                 => $request->type,
            'scheduled_at'         => $request->scheduled_at,
            'max_participants'     => $request->max_participants,
            'free_sessions_earned' => $request->free_sessions_earned,
        ]);

        return redirect()->route('dashboard')->with('success', 'Mission solidaire créée avec succès !');
    }

    public function destroy(Activity $activity)
    {
        Gate::authorize('delete', $activity);

        $validatedCount = $activity->participations()->where('is_validated', true)->count();
        if ($validatedCount > 0) {
            return back()->withErrors([
                'error' => "Impossible de supprimer : {$validatedCount} participant(s) sont déjà confirmés."
            ]);
        }

        $activity->participations()->delete();
        $activity->delete();

        return redirect()->route('dashboard')->with('success', 'Mission supprimée.');
    }

    /**
     * Un patient demande à rejoindre une mission solidaire.
     */
    public function join(Activity $activity)
    {
        Gate::authorize('join', $activity);

        if ($activity->scheduled_at < now()) {
            return back()->withErrors(['error' => 'Cette mission est déjà terminée.']);
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
        Gate::authorize('manageParticipations', $activity);

        $action = $request->input('action');

        if ($action === 'accept') {
            // La capacite maximale est atteinte juste avant la validation
            if ($activity->isFull()) {
                return back()->withErrors(['error' => 'Impossible de valider : la mission est complète.']);
            }

            $participation->update(['status' => 'accepted', 'is_validated' => true]);
            
            return back()->with('success', 'Participation acceptée ! En attente de réalisation.');

        } elseif ($action === 'reject') {
            $participation->update(['status' => 'rejected', 'is_validated' => false]);
            return back()->with('success', 'Participation refusée.');
            
        } elseif ($action === 'mark_present') {
            $participation->update(['status' => 'attended']);
            
            if ($activity->free_sessions_earned > 0) {
                $participation->patient->increment('credits', $activity->free_sessions_earned);
            }
            return back()->with('success', 'Présence validée ! Le patient a reçu ses crédits virtuels.');

        } elseif ($action === 'mark_absent') {
            $participation->update(['status' => 'rejected', 'is_validated' => false]);
            return back()->with('success', 'Absence signalée. Aucun crédit n\'a été accordé.');
        }

        return back()->withErrors(['error' => 'Action non reconnue.']);
    }
}
