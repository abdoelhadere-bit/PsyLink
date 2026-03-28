<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfessionalController;    
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfessionalProfileController;


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

Route::get('/professionals', [ProfessionalController::class, 'index'])->name('professionals.index');

Route::get('/professionals/{id}', [ProfessionalController::class, 'show'])->name('professionals.show');

Route::post('/admin/validate/{id}', [DashboardController::class, 'validatePro'])->name('admin.validate')->middleware('auth');   


// -- Profil du Professionnel --
Route::get('/professional/profile', [ProfessionalProfileController::class, 'edit'])->name('professional.profile.edit')->middleware('auth');
Route::put('/professional/profile', [ProfessionalProfileController::class, 'update'])->name('professional.profile.update')->middleware('auth');

// -- Rendez-vous --
Route::get('/appointments/create/{professional_id}', [AppointmentController::class, 'create'])->name('appointments.create')->middleware('auth');

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store')->middleware('auth');

Route::post('/appointments/{appointment}/accept', [AppointmentController::class, 'accept'])->name('appointments.accept')->middleware('auth');
Route::post('/appointments/{appointment}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject')->middleware('auth');
Route::post('/appointments/{appointment}/start', [AppointmentController::class, 'start'])->name('appointments.start')->middleware('auth');
Route::post('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])->name('appointments.complete')->middleware('auth');

Route::get('/appointments/{appointment}/room', [AppointmentController::class, 'room'])->name('appointments.room')->middleware('auth');


Route::get('/checkout/{appointment}', [CheckoutController::class, 'show'])->name('checkout.show')->middleware('auth');
Route::post('/checkout/{appointment}', [CheckoutController::class, 'process'])->name('checkout.process')->middleware('auth');
