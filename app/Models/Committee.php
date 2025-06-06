<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'role',
        'status',
        'assigned_rounds',
        'assigned_criteria'
    ];

    protected $casts = [
        'assigned_rounds' => 'array',
        'assigned_criteria' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'user_id', 'user_id');
    }

    public function assignedRounds()
    {
        return $this->belongsToMany(Round::class, 'committee_rounds', 'committee_id', 'round_id');
    }

    public function assignedCriteria()
    {
        return $this->belongsToMany(Criteria::class, 'committee_criteria', 'committee_id', 'criteria_id');
    }
}
