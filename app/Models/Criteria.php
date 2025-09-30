<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;
    protected $table = 'criteria';
    protected $fillable = [
        'round_id',
        'highest_rate',
        'lowest_rate',
        'criteria_description',

    ];

    public function round()
    {
        return $this->belongsTo(Round::class);
    }
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    // Judges hidden for this criteria
    public function hiddenJudges()
    {
        return $this->belongsToMany(User::class, 'criteria_hidden_judges', 'criteria_id', 'judge_id');
    }
}
