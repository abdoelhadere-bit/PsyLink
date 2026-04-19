<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Appointment;
use Carbon\Carbon;

class StoreAppointmentRequest extends FormRequest
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
            'professional_id' => 'required|exists:professionals,id',
            'scheduled_at' => 'required|date|after:now',
            'type' => 'required|string|in:video',
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->scheduled_at || !$this->professional_id) return; 

            try {
                $scheduledAt = Carbon::parse($this->scheduled_at);
                $professionalId = $this->professional_id;
             
                $startWindow = $scheduledAt->copy()->subMinutes(59);
                $endWindow = $scheduledAt->copy()->addMinutes(59);
                
                $overlap = Appointment::where('professional_id', $professionalId)
                    ->whereNotIn('status', ['rejected', 'cancelled', 'completed']) 
                    ->whereBetween('scheduled_at', [$startWindow, $endWindow])
                    ->exists();

                if ($overlap) {
                    $validator->errors()->add('scheduled_at', 'Le praticien est déjà occupé sur ce créneau horaire.');
                }

                $patientOverlap = Appointment::where('patient_id', auth()->user()->patient->id)
                    ->whereNotIn('status', ['rejected', 'cancelled', 'completed'])
                    ->whereBetween('scheduled_at', [$startWindow, $endWindow])
                    ->exists();

                if ($patientOverlap) {
                    $validator->errors()->add('scheduled_at', 'Vous avez déjà un autre rendez-vous prévu sur ce créneau horaire.');
                }
            } catch (\Exception $e) {
            }
        });
    }

}