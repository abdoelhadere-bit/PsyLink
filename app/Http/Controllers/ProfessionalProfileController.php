<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Request\UpdateProfessionalProfileRequest;

class ProfessionalProfileController extends Controller
{
    public function edit()
    {
        Gate::authorize('professional');

        $user = auth()->user();
        $professional = $user->professional;
        return view('professional.profile', compact('professional'));
    }

    public function update(UpdateProfessionalProfileRequest $request)
    {
        Gate::authorize('professional');

        $user = auth()->user();

        $user->professional->update([
            'specialty' => $request->specialty,
            'bio' => $request->bio,
            'hourly_rate' => $request->hourly_rate,
        ]);

        return redirect()->route('dashboard')->with('success', 'Votre profil professionnel a été mis à jour.');
    }
}
