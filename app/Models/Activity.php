<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Participation;

class Activity extends Model
{
    protected $fillable = [
        'association_id',
        'title',
        'description',
        'type',
        'city',
        'scheduled_at',
        'max_participants',
        'available_places',
        'free_sessions_earned',
    ];

    protected $casts = [
        'free_sessions_earned' => 'integer',
        'max_participants'     => 'integer',
        'available_places'     => 'integer',
        'scheduled_at'         => 'datetime',
    ];

    public function association()
    {
        return $this->belongsTo(Association::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Patient::class, 'participations')->withPivot('is_validated', 'status');
    }

   
    public function isFull(): bool
    {
        return $this->available_places <= 0;
    }

   
    public function getFillRateAttribute(): float
    {
        if ($this->max_participants <= 0) {
            return 0;
        }

        $validatedCount = $this->validated_count ?? $this->participations()->where('is_validated', true)->count();
        
        $progress = ($validatedCount / $this->max_participants) * 100;
        
        return min($progress, 100);
    }
}
