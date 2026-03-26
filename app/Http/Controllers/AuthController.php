<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Professional;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisteredUserRequest;
use App\Http\Requests\LoginUserRequest;

class AuthController extends Controller
{
    public function register(RegisteredUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
            ]);
        } else {
            Professional::create([
                'user_id' => $user->id,
            ]);
        }

        Auth::login($user);

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
