<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'contestant_id',
        'event_id',
        'user_id',
        'rate',
        'round_id',
        'criteria_id', // Add criteria_id to fillable attributes
    ];

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }

    public function round()
    {
        return $this->belongsTo(Round::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class); // Define the relationship with Criteria model
    }
    public function judge()
    {
        return $this->belongsTo(Judge::class, 'user_id', 'id');
    }

    
    
}
