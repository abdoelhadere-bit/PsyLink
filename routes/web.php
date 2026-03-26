<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfessionalController;    


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest');

Route::post ('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', function () {
    return view('auth.register');
})->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/about', function () {
    return view('about');
})->middleware('auth');  

Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index')->middleware('auth');

Route::get('/professionals/{id}', [ProfessionalController::class, 'show'])->name('professionals.show')->middleware('auth');

Route::post('/admin/validate/{id}', [DashboardController::class, 'validatePro'])->name('admin.validate')->middleware('auth');   

Route::get('/appointments/create/{professional_id}', [AppointmentController::class, 'create'])->name('appointments.create')->middleware('auth');

Route::get('/checkout', function () {
    return view('checkout.index');
});
