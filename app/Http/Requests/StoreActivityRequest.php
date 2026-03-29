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
            'title'            => ['required', 'string', 'min:5', 'max:150'],
            'description'      => ['required', 'string', 'min:20'],
            'type'             => ['nullable', 'string', 'max:80'],
            'scheduled_at'     => ['required', 'date', 'after:' . now()->addHour()->toDateTimeString()],
            'max_participants' => ['required', 'integer', 'min:2', 'max:50'],
        ];
    }

    /**
     * Messages d'erreur personnalisés en Français.
     */
    public function messages(): array
    {
        return [
            'title.required'            => 'Le titre du webinaire est obligatoire.',
            'title.min'                 => 'Le titre doit contenir au moins 5 caractères.',
            'description.required'      => 'La description est obligatoire.',
            'description.min'           => 'La description doit contenir au moins 20 caractères.',
            'scheduled_at.required'     => 'La date et l\'heure du webinaire sont obligatoires.',
            'scheduled_at.after'        => 'Le webinaire doit être planifié au moins 1 heure dans le futur.',
            'max_participants.required' => 'Le nombre de places est obligatoire.',
            'max_participants.min'      => 'Un webinaire doit accueillir au moins 2 participants.',
            'max_participants.max'      => 'Un webinaire ne peut pas dépasser 50 participants.',
        ];
    }
}
