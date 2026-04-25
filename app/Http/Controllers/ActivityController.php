<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Models\Activity;
use App\Models\Participation;
use Illuminate\Http\Request;
use App\Policies\ActivityPolicy;
use Illuminate\Support\Facades\Gate;
use App\Services\NotificationService;


class ActivityController extends Controller
{

    public function index(Request $request)
    {
        $activities = Activity::with('association')->orderBy('scheduled_at', 'asc')->get();
        $userParticipations = [];
        
        //Creer un tableu pour les id  des activites et leurs status
        if (auth()->check() && auth()->user()->role === 'patient') {
            $userParticipations = auth()->user()->patient->activities->pluck('pivot.status', 'id')->toArray();
        }

        // Ordre de priorité : accepted > pending > attended > available 
        $statusOrder = ['accepted' => 0, 'pending' => 1, 'attended' => 2, 'rejected' => 99];

        $activities = $activities->sortBy(function ($activity) use ($userParticipations, $statusOrder) {
            $status = $userParticipations[$activity->id] ?? 'available';
            if ($status === 'available') return 3;
            return $statusOrder[$status] ?? 99; 
        })->values();

        // Filtre par texte et ville
        $search = $request->query('search');
        $city = $request->query('city');
        
        if ($search) {
            $activities = $activities->filter(fn($a) => 
                str_contains(strtolower($a->title), strtolower($search)) || 
                str_contains(strtolower($a->description), strtolower($search))
            );
        }
        
        if ($city) {
            $activities = $activities->filter(fn($a) => $a->city === $city);
        }

        // Filtre par statut
        $filter = $request->query('filter');
        if ($filter && $filter !== 'all') {
            if ($filter === 'available') {
                $activities = $activities->filter(fn($a) => !isset($userParticipations[$a->id]));
            } else {
                $activities = $activities->filter(fn($a) => ($userParticipations[$a->id] ?? null) === $filter);
            }
        }

        return view('activities.index', compact('activities', 'userParticipations', 'filter', 'search', 'city'));
    }

    public function store(StoreActivityRequest $request)
    {
        Gate::authorize('create', Activity::class);

        Activity::create([
            'association_id'       => $request->association_id,
            'title'                => $request->title,
            'description'          => $request->description,
            'type'                 => $request->type,
            'city'                 => $request->city,
            'scheduled_at'         => $request->scheduled_at,
            'max_participants'     => $request->max_participants,
            'available_places'     => $request->max_participants,
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

        // E-mail à l'association
        $associationUser = $activity->association->user ?? null;
        if ($associationUser) {
            NotificationService::sendEmail(
                $associationUser,
                'Nouvelle demande de participation',
                "Bonjour,\n\nLe patient {$patient->user->name} souhaite rejoindre votre mission solidaire \"{$activity->title}\".\n\nConnectez-vous à votre espace pour accepter ou refuser cette demande."
            );
        }

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
            $activity->decrement('available_places');

            // E-mail au patient : participation acceptée
            NotificationService::sendEmail(
                $participation->patient->user,
                'Votre participation a été acceptée !',
                "Bonjour {$participation->patient->user->name},\n\nVotre demande de participation à la mission solidaire \"{$activity->title}\" a été acceptée.\n\u00c0 très bientôt !"
            );

            return back()->with('success', 'Participation acceptée ! Une place a été réservée.');

        } elseif ($action === 'reject') {
            if ($participation->status === 'accepted') {
                $activity->increment('available_places');
            }
            $participation->update(['status' => 'rejected', 'is_validated' => false]);
            return back()->with('success', 'Participation refusée. La place a été libérée.');
            
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
