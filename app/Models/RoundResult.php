<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoundResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'round_id',
        'contestant_id',
        'total_score',
        'qualified',
    ];

    // Define the relationship with the Round model
    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    // Define the relationship with the Contestant model
    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }
}
