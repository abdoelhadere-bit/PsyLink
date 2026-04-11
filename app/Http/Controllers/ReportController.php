<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\StoreReportRequest;
use App\Models\Report;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
   
    public function store(StoreReportRequest $request)
    {
        
        $patient = auth()->user()->patient;

        // le patient ne peut pas signaler le même psy plusieurs fois
        $existingReport = Report::where('patient_id', $patient->id)
            ->where('professional_id', $request->professional_id)
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return back()->with('error', 'Vous avez déjà un signalement en attente de traitement pour ce praticien.');
        }

        Report::create([
            'patient_id'      => $patient->id,
            'professional_id' => $request->professional_id,
            'reason'          => $request->reason,
            'status'          => 'pending' 
        ]);

        return back()->with('success', 'Votre signalement a bien été transmis aux administrateurs. Nous traiterons votre demande dans les plus brefs délais.');
    }

    public function resolve(Report $report)
    {
        Gate::authorize('admin');

        $report->status = 'resolved';
        $report->save();

        return back()->with('success', 'Le signalement a été classé comme traité.');
    }
}
