<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/dashboard', function () {
    return 'Bienvenue sur ton Dashboard ! L\'inscription a réussi 🎉';
})->name('dashboard')->middleware('auth');

Route::get('/about', function () {
    return view('about');
});

// Phase 3: Flow de Réservation
Route::get('/professionals', function () {
    return view('professionals.index');
});

Route::get('/professionals/{id}', function ($id) {
    return view('professionals.show');
});

Route::get('/sessions/create', function () {
    return view('sessions.create');
});

Route::get('/checkout', function () {
    return view('checkout.index');
});
