<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Professional;
use App\Models\Activity;
use Illuminate\Support\Facades\Gate;
use App\Models\Appointment;
use App\Models\Participation;
use App\Models\Report;
use App\Http\Controllers\Dashboards\PatientDashboardController;
use App\Http\Controllers\Dashboards\ProfessionalDashboardController;
use App\Http\Controllers\Dashboards\AssociationDashboardController;
use App\Http\Controllers\Dashboards\AdminDashboardController;


class DashboardController extends Controller
{
    public function index()
    {
        return match (auth()->user()->role) {
            'patient' => app()->call(PatientDashboardController::class),
            'professional' => app()->call(ProfessionalDashboardController::class),
            'association' => app()->call(AssociationDashboardController::class),
            'admin' => app()->call(AdminDashboardController::class),
            default => view('welcome'),
        };
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
