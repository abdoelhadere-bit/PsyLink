<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;

class CheckoutController extends Controller
{
    public function show(Appointment $appointment)
    {
        // Seules les séances en attente de paiement peuvent être réglées
        if ($appointment->status !== 'waiting_payment') {
            return redirect()->route('dashboard')->with('error', 'Cette séance ne nécessite pas de paiement ou a déjà été réglée.');
        }

        // Seul le patient concerné peut accéder au paiement
        if (auth()->user()->role !== 'patient' || auth()->user()->patient->id !== $appointment->patient_id) {
            abort(403, 'Vous ne pouvez pas payer ce rendez-vous.');
        }

        return view('checkout.index', compact('appointment'));
    }

    public function process(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'waiting_payment') {
            return redirect()->route('dashboard')->with('error', 'Le paiement n\'est pas requis.');
        }

        if (auth()->user()->role !== 'patient' || auth()->user()->patient->id !== $appointment->patient_id) {
            abort(403);
        }
        $request->validate([
            'card_name' => ['required', 'string', 'max:255'],
            'card_number' => ['required', 'string', 'regex:/^[\d\s]{16,19}$/'],
            'exp_date' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
            'cvc' => ['required', 'string', 'regex:/^[0-9]{3,4}$/'],
        ], [
            'exp_date.regex' => 'La date d\'expiration doit être au format MM/YY (ex: 12/26)',
            'card_number.regex' => 'Numéro de carte invalide.',
            'cvc.regex' => 'Cryptogramme invalide.',
        ]);
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
