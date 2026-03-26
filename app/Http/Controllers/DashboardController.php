<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Professional;
use Illuminate\Support\Facades\Gate;


class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'patient') {

            return view('dashboard.patient');

        } else if (auth()->user()->role === 'professional') {
            if(auth()->user()->professional->is_valid){
                return view('dashboard.professional');
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
