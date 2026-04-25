<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $table = 'professionals';
    protected $fillable = [
        'user_id',
        'specialty',
        'is_valid',
        'hourly_rate',
        'accepts_credits',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'accepts_credits' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Appointment::class, 'professional_id', 'appointment_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
