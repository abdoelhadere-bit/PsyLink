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
        $query = Professional::with('user')->withAvg('reviews', 'rating')->where('is_valid', true);

        if ($request->filled('specialty')) {
            $query->where('specialty', 'like', '%' . $request->specialty . '%');
        }

        if ($request->filled('price_max')) {
            $query->where('hourly_rate', '<=', $request->price_max);
        }

        if ($request->filled('city')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('city', 'like', '%' . $request->city . '%');
            });
        }

        if ($request->filled('search')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // Sorting
        $sort = $request->get('sort', 'recommended');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('hourly_rate', 'asc');
                break;
            case 'rating_desc':
                $query->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'rating_asc':
                $query->orderBy('reviews_avg_rating', 'asc');
                break;
            default:
                $query->latest();
                break;
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
                ->whereDoesntHave('review')
                ->latest('scheduled_at')
                ->first();
        }

        $reviews = $professional->reviews()->with('appointment.patient.user')->latest()->get();
        $avgRating = $reviews->avg('rating');
        $totalReviews = $reviews->count();

        return view('professionals.show', compact('professional', 'eligibleAppointment', 'reviews', 'avgRating', 'totalReviews'));
    }

}
