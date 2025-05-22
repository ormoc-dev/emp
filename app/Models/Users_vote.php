<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'contestant_id',
        'user_id',
        'event_id',
        'vote_count',
    ];

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function category()
    {
        return $this->belongsTo(VotingCategory::class, 'event_id', 'event_id');
    }
}
