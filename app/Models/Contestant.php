<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
class Contestant extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'number',
        'category',
        'profile',
        'rankings',
        'progress',
    ];

    // Define the relationship with the Event model if necessary
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

   

    public function rounds()
    {
        return $this->belongsToMany(Round::class, 'round_contestant', 'contestant_id', 'round_id')
                    ->withTimestamps();
    }

    public function minorAwardScores()
    {
        return $this->hasMany(MinorAwardScore::class);
    }
    
    public function overallMinorAwardScores()
    {
        return $this->hasMany(overall_Minoraward_scores::class);
    }
    public function roundResults()
    {
        return $this->hasMany(RoundResult::class);
    }
    public function votes()
{
        return $this->hasMany(Users_vote::class, 'contestant_id');
    }
}
