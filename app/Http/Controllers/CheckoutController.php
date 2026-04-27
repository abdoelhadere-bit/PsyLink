<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Payment;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ProcessCheckoutRequest;
use App\Services\NotificationService;


class CheckoutController extends Controller
{
    public function show(Appointment $appointment)
    {
        // Seules les séances en attente de paiement peuvent être réglées
        if ($appointment->status !== 'waiting_payment') {
            return redirect()->route('dashboard')->with('error', 'Cette séance ne nécessite pas de paiement ou a déjà été réglée.');
        }

        // Seul le patient concerné peut accéder au paiement
        Gate::authorize('checkout', $appointment);

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
            if (!$appointment->professional->accepts_credits) {
                return back()->with('error', 'Ce praticien n\'accepte pas les cœurs solidaires pour le moment.');
            }

            if ($patient->credits < 1) {
                return back()->with('error', 'Vous n\'avez pas assez de cœurs ❤️ pour cette séance.');
            }
            $patient->decrement('credits', 1);
            $appointment->update(['status' => 'paid']);
            // Reçu au patient (paiement par crédits)
            NotificationService::sendEmail(
                $patient->user,
                'Reçu de paiement — PsyLink',
                "Bonjour {$patient->user->name},\n\nVotre paiement a bien été enregistré via vos crédits solidaires.\n\n"
                . "— Séance avec : Dr. {$appointment->professional->user->name}\n"
                . "— Date : " . \Carbon\Carbon::parse($appointment->scheduled_at)->format('d/m/Y à H:i') . "\n"
                . "— Mode de paiement : Crédit solidaire\n"
                . "— Montant : {$appointment->price}€\n\n"
                . "Votre séance est confirmée. À bientôt sur PsyLink !"
            );
            // E-mail au pro
            NotificationService::sendEmail(
                $appointment->professional->user,
                'Séance réglée (crédits solidaires)',
                "Bonjour Dr. {$appointment->professional->user->name},\n\nLa séance avec {$patient->user->name} a été réglée via les crédits solidaires du patient. Vous pouvez la démarrer dès que vous êtes prêt."
            );
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
        // Reçu au patient (paiement par carte)
        NotificationService::sendEmail(
            $appointment->patient->user,
            'Reçu de paiement — PsyLink',
            "Bonjour {$appointment->patient->user->name},\n\nVotre paiement a bien été enregistré.\n\n"
            . "— Séance avec : Dr. {$appointment->professional->user->name}\n"
            . "— Date : " . \Carbon\Carbon::parse($appointment->scheduled_at)->format('d/m/Y à H:i') . "\n"
            . "— Mode de paiement : Carte bancaire\n"
            . "— Montant : {$appointment->price}€\n\n"
            . "Votre séance est confirmée. À bientôt sur PsyLink !"
        );
        // E-mail au pro
        NotificationService::sendEmail(
            $appointment->professional->user,
            'Paiement reçu pour une séance',
            "Bonjour Dr. {$appointment->professional->user->name},\n\n{$appointment->patient->user->name} vient de régler la séance ({$appointment->price}€). Vous pouvez la démarrer dès que vous êtes prêt."
        );
        return redirect()->route('dashboard')->with('success', 'Paiement de ' . $appointment->price . '€ validé avec succès ! Votre séance est confirmée et n\'attend plus que le médecin.');
    }
}
