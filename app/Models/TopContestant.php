<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopContestant extends Model
{
    use HasFactory;

    protected $fillable = ['round_id', 'contestant_id', 'score'];

    // Define the relationship to Round
    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    // Define the relationship to Contestant
    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }
}
