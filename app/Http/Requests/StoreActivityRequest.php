<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreActivityRequest extends FormRequest
{
    /**
     * Seule une Association peut créer une activité (vérification via la Policy).
     */
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->role === 'association'
            && auth()->user()->association !== null;
    }

    /**
     * Règles de validation de chaque champ.
     */
    public function rules(): array
    {
        return [
            'association_id'       => 'exists:associations,id',
            'title'                => 'required|string|min:5|max:150',
            'description'          => ['required', 'string', 'min:20'],
            'type'                 => ['nullable', 'string', 'max:80'],
            'scheduled_at'         => ['required', 'date', 'after:' . now()->addHour()->toDateTimeString()],
            'max_participants'     => ['required', 'integer', 'min:2', 'max:50'],
            'free_sessions_earned' => ['required', 'integer', 'min:0', 'max:5']
        ];
    }

    /**
     * Messages d'erreur personnalisés en Français.
     */
    public function messages(): array
    {
        return [
            'title.required'            => 'Le titre de la mission est obligatoire.',
            'title.min'                 => 'Le titre doit contenir au moins 5 caractères.',
            'description.required'      => 'La description est obligatoire.',
            'description.min'           => 'La description doit contenir au moins 20 caractères.',
            'scheduled_at.required'     => 'La date et l\'heure de la mission sont obligatoires.',
            'scheduled_at.after'        => 'La mission doit être planifiée au moins 1 heure dans le futur.',
            'max_participants.required' => 'Le nombre de places est obligatoire.',
            'max_participants.min'      => 'Une mission doit accueillir au moins 2 participants.',
            'max_participants.max'      => 'Une mission ne peut pas dépasser 50 participants.',
            'free_sessions_earned.required' => 'Le nombre de séances offertes est obligatoire.',
            'free_sessions_earned.min'  => 'Le nombre de séances offertes ne peut être négatif.',
            'free_sessions_earned.max'  => 'Le nombre de séances offertes ne peut dépasser 5.',
        ];
    }
}
