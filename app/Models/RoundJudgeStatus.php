<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoundJudgeStatus extends Model
{
    use HasFactory;

    protected $table = 'round_judge_status';

    protected $fillable = [
     
        'round_id',
        'user_id',
        'completed',
    ];

    // If you want to define relationships
    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
