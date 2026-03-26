<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Professional;
class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'patient') {

            return view('dashboard.patient');
        } else if (auth()->user()->role === 'professional') {
            return view('dashboard.professional');

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
        if($pro->user->role !== 'admin') abort(403);

        $pro->is_valid = true;
        $pro->save();
        return redirect()->route('dashboard');  
    }
}
