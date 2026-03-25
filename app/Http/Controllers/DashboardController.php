<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'patient') {
            return view('dashboard.patient');
        } else {
            return view('dashboard.professional');
        }
    }
}
