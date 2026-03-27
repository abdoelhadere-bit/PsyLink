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

            $nonValidPros = Professional::where('is_valid', false)->with('user')->get();
            return view('dashboard.admin', compact('nonValidPros'));
        } else {
            return view('welcome');
        }
    }

    public function validatePro($id)
    {
        $pro = Professional::find($id);
        Gate::authorize('admin');

        $pro->is_valid = true;
        $pro->save();
        return redirect()->route('dashboard');  
    }
}
