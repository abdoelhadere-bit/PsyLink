<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professional;   
use App\Models\Appointment;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Professional::with('user')->where('is_valid', true);

        if ($request->filled('specialty')) {
            $query->where('specialty', $request->specialty);
        }

        if ($request->filled('price_max')) {
            $query->where('hourly_rate', '<=', $request->price_max);
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        $professionals = $query->get();
        return view('professionals.index', compact('professionals'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $professional = Professional::with('user')->findOrFail($id);
        
        $eligibleAppointment = null;

        if (auth()->check() && auth()->user()->role === 'patient') {
            $eligibleAppointment = Appointment::where('professional_id', $professional->id)
                ->where('patient_id', auth()->user()->patient->id)
                ->where('status', 'completed')
                ->whereDoesntHave('reviews', function($q) {
                    $q->where('reviewer_id', auth()->id());
                })
                ->latest('scheduled_at')
                ->first();
        }

        $reviews = $professional->reviews()->with('reviewer')->latest()->get();
        $avgRating = $reviews->avg('rating');
        $totalReviews = $reviews->count();

        return view('professionals.show', compact('professional', 'eligibleAppointment', 'reviews', 'avgRating', 'totalReviews'));
    }

}
