<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Users_vote;
use App\Models\Event;
class VotingCategory extends Model
{
    protected $fillable = [
        'event_id',
        'category_name',
        'points_per_vote',
        'category_icon',
        'is_active'
    ];

    // Relationship with Event
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    // Get votes through the existing users_votes table
    public function votes(): HasManyThrough
    {
        return $this->hasManyThrough(
            Users_vote::class,
            Event::class,
            'id', // Foreign key on events table
            'event_id', // Foreign key on users_votes table
            'event_id', // Local key on voting_categories table
            'id' // Local key on events table
        );
    }
}