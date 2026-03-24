<?php

namespace App\Models;


class Professional extends User
{
    protected $table = 'professionals';
    protected $fillable = [
        'user_id',
        'specialty',
        'bio',
        'is_valid',
        'hourly_rate',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'hourly_rate' => 'decimal:2',
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
