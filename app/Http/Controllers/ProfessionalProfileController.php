<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;


class ProfessionalProfileController extends Controller
{
    public function edit()
    {
        Gate::authorize('professional');

        $user = auth()->user();
        $professional = $user->professional;
        return view('professional.profile', compact('professional'));
    }

    public function update(Request $request)
    {
        Gate::authorize('professional');

        $request->validate([
            'specialty'       => 'nullable|string|max:100',
            'bio'             => 'nullable|string|max:1000',
            'hourly_rate'     => 'nullable|numeric|min:0|max:500',
            'photo'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'accepts_credits' => 'sometimes|boolean',
        ]);

        $user = auth()->user();

        // Upload de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('photos/professionals', 'public');
            $user->update(['photo' => $path]);
        }

        $user->professional->update([
            'specialty'       => $request->specialty,
            'bio'             => $request->bio,
            'hourly_rate'     => $request->hourly_rate,
            'accepts_credits' => $request->has('accepts_credits'),
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil mis à jour avec succès !');
    }
}
