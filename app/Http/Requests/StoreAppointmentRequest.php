<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // On retourne 'true' car tout utilisateur connecté a le droit de soumettre ce formulaire
        return auth()->check() && auth()->user()->role === 'patient';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'professional_id' => 'required|exists:professionals,id',
            'scheduled_at' => 'required|date|after:now',
            'type' => 'required|string|in:chat,video',
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_at.required' => 'Veuillez choisir une date et une heure.',
            'scheduled_at.after' => 'La date du rendez-vous doit être dans le futur.',
            'type.in' => 'Format de séance invalide.',
            'professional_id.exists' => 'Le professionnel sélectionné n\'existe pas.'
        ];
    }

}