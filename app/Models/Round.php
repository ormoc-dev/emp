<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $fillable = [
        'event_id',
        'round_number',
        'round_description',
        'top_contestants'
    ];
    protected $casts = [
        'top_contestants' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function criteria()
    {
        return $this->hasMany(Criteria::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
 // Define the relationship with TopContestant
 public function topContestants()
 {
     return $this->hasMany(TopContestant::class);
 }

 public function judges()
    {
        return $this->belongsToMany(User::class, 'round_judge_status');
    }

    public function completed_by_judges()
    {
        return $this->belongsToMany(User::class, 'round_judge_status')->wherePivot('completed', true);
    }
    public function roundResults()
    {
        return $this->hasMany(RoundResult::class);
    }
    public function contestants()
    {
        return $this->belongsToMany(Contestant::class, 'round_contestant', 'round_id', 'contestant_id')
                    ->withTimestamps();
    }

    public function results()
    {
        return $this->hasMany(RoundResult::class);
    }
    public function judgeStatuses()
{
    return $this->hasMany(RoundJudgeStatus::class);
}
public function scopeIncomplete($query)
{
    return $query->where('completed', false);
}
}
