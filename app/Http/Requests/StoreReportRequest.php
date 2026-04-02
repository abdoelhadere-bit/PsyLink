<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreReportRequest extends FormRequest
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
            'reason' => 'required|string|min:20',
            'professional_id' => 'required|exists:professionals,id',
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => 'La raison est obligatoire.',
            'reason.min' => 'La raison doit contenir au moins 20 caractères.',
            'professional_id.required' => 'Le professionnel introuvable.',
            'professional_id.exists' => 'Le professionnel n\'existe pas.',
        ];
    }
}
