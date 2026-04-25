<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $table = 'patients';
    protected $fillable = [
        'user_id',
        'credits',
        'birth_date',
        'gender',
    ];

    protected $casts = [
        'birth_date' => 'date',
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
