<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Professional;
use App\Models\Association;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisteredUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Services\NotificationService;


class AuthController extends Controller
{
    public function register(RegisteredUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'city' => $request->city,
        ]);

        if ($request->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
            ]);
        } elseif ($request->role === 'professional') {
            Professional::create([
                'user_id' => $user->id,
            ]);
        } elseif ($request->role === 'association') {
            Association::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'description' => 'Nouvelle association partenaire',
            ]);
        }

        Auth::login($user);

        // E-mail de bienvenue
        NotificationService::sendEmail(
            $user,
            'Bienvenue sur PsyLink !',
            "Bonjour {$user->name},\n\nVotre compte a bien été créé sur PsyLink. Vous pouvez dès maintenant vous connecter et utiliser notre plateforme.\n\nÀ bientôt,\nL'équipe PsyLink"
        );

        return redirect()->route('dashboard');
    }

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            // dd($credentials);
            $request->session()->regenerate();
            
            return redirect()->route('dashboard');

        } else {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);     
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
