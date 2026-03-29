<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = [
        'patient_id',
        'activity_id',
        'status',
        'is_validated',
    ];

    protected $casts = [
        'is_validated' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
