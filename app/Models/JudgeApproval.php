<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JudgeApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'judge_id',
        'event_id',
        'approval_type',
        'minor_award_id',
        'contestant_id',
        'round_id',
    ];

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }
    
}