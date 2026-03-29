<?php

namespace App\Models;


class Patient extends User
{
    protected $table = 'patients';
    protected $fillable = [
        'user_id',
        'credits'
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
        return $this->hasManyThrough(Review::class, Appointment::class, 'patient_id', 'appointment_id');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'participations')->withPivot('status', 'is_validated');
    }
}
