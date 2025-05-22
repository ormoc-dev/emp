<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventJudge extends Model
{
    protected $table = 'event_judge'; // Specify the table name if it's different from the default convention

    protected $fillable = [
        'event_id',
        'judge_id',
        // Add other fillable attributes if needed
    ];

    // Define the relationships with Event and Judge models
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_id');
    }
}
