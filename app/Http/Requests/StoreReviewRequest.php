<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'appointment_id' => 'required|exists:appointments,id',
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'Veuillez sélectionner une note.',
            'rating.integer' => 'La note doit être un nombre entier.',
            'rating.min' => 'La note minimale est de 1 étoile.',
            'rating.max' => 'La note maximale est de 5 étoiles.',
            'comment.required' => 'Veuillez saisir un commentaire.',
            'comment.min' => 'Le commentaire doit contenir au moins 10 caractères.',
            'comment.max' => 'Le commentaire ne doit pas dépasser 1000 caractères.',
        ];
    }
}
