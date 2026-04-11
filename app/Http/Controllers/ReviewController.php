<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Appointment;

class ReviewController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();
        
        $appointment = Appointment::findOrFail($validated['appointment_id']);
        
        \Illuminate\Support\Facades\Gate::authorize('create', [\App\Models\Review::class, $appointment]);
        $review = Review::create([
            'appointment_id' => $validated['appointment_id'],
            'reviewer_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('professionals.show', $appointment->professional_id)->with('success', 'Avis enregistré avec succès !');    
    }


}
