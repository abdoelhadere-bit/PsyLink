<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Professional;
use App\Models\Patient;
use App\Models\Appointment;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_anonymous',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_anonymous' => 'boolean',
        ];
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function association()
    {
        return $this->hasOne(Association::class);
    }

    public function professional()
    {
        return $this->hasOne(Professional::class);
    }

    public function appointmentsAsPatient()
    {
        return $this->hasManyThrough(Appointment::class, Patient::class, 'user_id', 'patient_id', 'id', 'id');
    }

    public function appointmentsAsProfessional()
    {
        return $this->hasManyThrough(Appointment::class, Professional::class, 'user_id', 'professional_id', 'id', 'id');
    }
}
