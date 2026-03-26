<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function create($professional_id)
    {
        dd("On veut prendre RDV avec le médecin ID : " . $professional_id);
    }
}
