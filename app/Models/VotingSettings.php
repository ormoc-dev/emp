<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotingSettings extends Model
{
    protected $fillable = [
        'event_id',
        'max_votes_per_user',
        'vote_cost'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}