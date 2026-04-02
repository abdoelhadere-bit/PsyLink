<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\StoreReportRequest;
use App\Models\Report;

class ReportController extends Controller
{
   
    public function store(StoreReportRequest $request)
    {
        
        $patient = auth()->user()->patient;

        // le patient essaie de re-signaler le même psy alors qu'une enquête est en cours
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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Accès non autorisé');
        }

        $report->status = 'resolved';
        $report->save();

        return back()->with('success', 'Le signalement a été classé comme traité.');
    }
}
