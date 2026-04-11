<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Participation;

class AssociationDashboardController extends Controller
{
    public function __invoke()
    {
        $association = auth()->user()->association;
        
        $activities = $association ? Activity::where('association_id', $association->id)
                      ->with(['participations' => function($q) {
                          $q->whereIn('status', ['accepted', 'attended'])->with('patient.user');
                      }])
                      ->withCount(['participations', 'participations as validated_count' => fn($q) => $q->where('is_validated', true)])
                      ->orderByDesc('scheduled_at')
                      ->get()
            : collect();

        $pendingParticipations = $association ? Participation::whereHas('activity', fn($q) => $q->where('association_id', $association->id))
                                       ->where('status', 'pending')
                                       ->with(['patient.user', 'activity'])
                                       ->get()
            : collect();

        return view('dashboard.association', compact('activities', 'pendingParticipations', 'association'));
    }
}
