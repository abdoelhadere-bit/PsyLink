<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'professional_id',
        'title',
        'description',
        'type',
        'free_sessions_earned',
    ];

    protected $casts = [
        'free_sessions_earned' => 'integer',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Patient::class, 'participations')->withPivot('completed_at');
    }
}
