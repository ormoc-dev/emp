<?php

namespace App\Models;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Judge extends Model
{
    use HasFactory;
   
    /**
     * The events that belong to the judge.
     */
    public function events_judge()
    {
        return $this->belongsToMany(Event::class, 'event_judge', 'judge_id', 'event_id','profile');
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
