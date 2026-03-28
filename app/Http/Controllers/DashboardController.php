<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Professional;
use Illuminate\Support\Facades\Gate;
use App\Models\Appointment;


class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'patient') {

    $appointments = Appointment::with('professional.user')->where('patient_id', auth()->user()->patient->id)->get();
            return view('dashboard.patient', compact('appointments'));

        } else if (auth()->user()->role === 'professional') {

            $appointments = Appointment::with('patient.user')->where('professional_id', auth()->user()->professional->id)->get();
            if(auth()->user()->professional->is_valid){
                return view('dashboard.professional', compact('appointments'));
            }else{
                return view('dashboard.pending');
            }

        } else if (auth()->user()->role === 'admin') {
            // Statistiques globales
            $totalPatients = User::where('role', 'patient')->count();
            $totalPros = Professional::where('is_valid', true)->count();
            $totalAppointments = Appointment::whereNotIn('status', ['pending', 'rejected', 'cancelled'])->count();

            // Listes de modération
            $pendingPros = Professional::where('is_valid', false)->with('user')->get();
            $activePros = Professional::where('is_valid', true)->with('user')->get();

            return view('dashboard.admin', compact('totalPatients', 'totalPros', 'totalAppointments', 'pendingPros', 'activePros'));
        } else {
            return view('welcome');
        }
    }

    public function toggleProStatus($id)
    {
        Gate::authorize('admin');
        $pro = Professional::findOrFail($id);

        $pro->is_valid = !$pro->is_valid;
        $pro->save();
        
        $action = $pro->is_valid ? 'validé et autorisé' : 'suspendu et bloqué';
        return redirect()->route('dashboard')->with('success', "Le compte du praticien a été $action avec succès.");
    }
}
