<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class overall_Minoraward_scores extends Model
{
    use HasFactory;

    protected $table = 'overall_minor_award_scores'; 


    protected $fillable = ['contestant_id', 'event_id', 'overall_score'];

    public function contestant()
    {
        return $this->belongsTo(Contestant::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
