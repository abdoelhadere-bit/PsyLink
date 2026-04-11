<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Si l'utilisateur paie avec ses crédits, on zappe la validation des de paiement
        if ($this->has('use_credits')) {
            return [];
        }

        return [
            'card_name' => ['required', 'string', 'max:255'],
            'card_number' => ['required', 'string', 'regex:/^[\d\s]{16,19}$/'],
            'exp_date' => ['required', 'string', 'regex:/^(0[1-9]|1[0-2])\/[0-9]{2}$/'],
            'cvc' => ['required', 'string', 'regex:/^[0-9]{3,4}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'exp_date.regex' => 'La date d\'expiration doit être au format MM/YY (ex: 12/26)',
            'card_number.regex' => 'Numéro de carte invalide.',
            'cvc.regex' => 'Cryptogramme invalide.',
        ];
    }
}
