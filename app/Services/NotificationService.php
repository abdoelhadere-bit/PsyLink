<?php

namespace App\Services;

use App\Mail\GenericNotification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Envoie un e-mail simple à un utilisateur.
     * 
     * @param User   $user    Le destinataire
     * @param string $subject L'objet de l'e-mail
     * @param string $message Le corps du message
     */
    public static function sendEmail(User $user, string $subject, string $message): void
    {
        try {
            Mail::to($user->email)->send(new GenericNotification($subject, $message));
        } catch (\Throwable $e) {
            // On ne bloque jamais l'action utilisateur à cause d'un email raté
            Log::error("Échec envoi email à {$user->email} : " . $e->getMessage());
        }
    }
}
