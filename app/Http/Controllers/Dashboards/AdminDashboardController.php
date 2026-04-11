<?php

namespace App\Http\Controllers\Dashboards;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Professional;
use App\Models\Appointment;
use App\Models\Report;

class AdminDashboardController extends Controller
{
    public function __invoke()
    {
        // Statistiques globales
        $totalPatients = User::where('role', 'patient')->count();
        $totalPros = Professional::where('is_valid', true)->count();
        $totalAppointments = Appointment::whereNotIn('status', ['pending', 'rejected', 'cancelled'])->count();

        // Listes de modération
        $pendingPros = Professional::where('is_valid', false)->with('user')->get();
        $activePros = Professional::where('is_valid', true)->with('user')->get();
        $pendingReports = Report::where('status', 'pending')->with(['patient.user', 'professional.user'])->get();

        return view('dashboard.admin', compact('totalPatients', 'totalPros', 'totalAppointments', 'pendingPros', 'activePros', 'pendingReports'));
    }
}
