<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinorAwardScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'contestant_id',
        'user_id',
        'minor_award_id',
        'event_id',
        'rate',
    ];

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function minorAward()
    {
        return $this->belongsTo(MinorAward::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
