<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSchedule extends Model
{
    use HasFactory;
    protected $table = 'event_time_schedule';
    protected $fillable = [
        'event_id',
        'time_start',
        'time_end'
    ];

    protected $casts = [
        'time_start' => 'datetime',
        'time_end' => 'datetime'
    ];

    /**
     * Get the event that owns the schedule
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}