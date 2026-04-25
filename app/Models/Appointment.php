<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'professional_id',
        'type',
        'status',
        'scheduled_at',
        'duration_minutes',
        'price',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }



    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function isReadyToStart(): bool
    {
        if (!$this->scheduled_at) {
            return false;
        }

        $allowedStartTime = $this->scheduled_at->copy()->subMinutes(15);
        return now()->greaterThanOrEqualTo($allowedStartTime);
    }
}
