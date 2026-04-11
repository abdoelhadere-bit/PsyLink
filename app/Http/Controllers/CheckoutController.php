<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProcessCheckoutRequest;

class CheckoutController extends Controller
{
    public function show(Appointment $appointment)
    {
        // Seules les séances en attente de paiement peuvent être réglées
        if ($appointment->status !== 'waiting_payment') {
            return redirect()->route('dashboard')->with('error', 'Cette séance ne nécessite pas de paiement ou a déjà été réglée.');
        }

        // Seul le patient concerné peut accéder au paiement
        \Illuminate\Support\Facades\Gate::authorize('checkout', $appointment);

        return view('checkout.index', compact('appointment'));
    }

    public function process(ProcessCheckoutRequest $request, Appointment $appointment)
    {
        $patient = auth()->user()->patient;
        if ($appointment->status !== 'waiting_payment') {
            return redirect()->route('dashboard')->with('error', 'Le paiement n\'est pas requis.');
        }

        Gate::authorize('checkout', $appointment);

        if ($request->has('use_credits')) {

            if ($patient->credits < 1) {
                return back()->with('error', 'Vous n\'avez pas assez de cœurs ❤️ pour cette séance.');
            }
            $patient->decrement('credits', 1);
            $appointment->update(['status' => 'paid']);
            return redirect()->route('dashboard')->with('success', 'Séance payée avec vos cœurs solidaire !');
        }
        Payment::create([
            'appointment_id' => $appointment->id,
            'amount' => $appointment->price,
            'status' => 'completed',
            'payment_method' => 'credit_card_mock',
            'transaction_id' => 'tx_mock_' . uniqid(),
        ]);
        $appointment->update(['status' => 'paid']);
        return redirect()->route('dashboard')->with('success', 'Paiement de ' . $appointment->price . '€ validé avec succès ! Votre séance est confirmée et n\'attend plus que le médecin.');
    }
}
