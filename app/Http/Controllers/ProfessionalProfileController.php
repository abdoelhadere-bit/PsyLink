<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfessionalProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        
        if ($user->role !== 'professional' || !$user->professional) {
            abort(403);
        }

        $professional = $user->professional;
        return view('professional.profile', compact('professional'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role !== 'professional' || !$user->professional) {
            abort(403);
        }

        $request->validate([
            'specialty' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'hourly_rate' => 'required|numeric|min:0|max:500',
        ]);

        $user->professional->update([
            'specialty' => $request->specialty,
            'bio' => $request->bio,
            'hourly_rate' => $request->hourly_rate,
        ]);

        return redirect()->route('dashboard')->with('success', 'Votre profil professionnel a été mis à jour.');
    }
}
