<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class TimeStatus extends Model
{
    use HasFactory;

     // Specify the table name if it's not the default plural form
     protected $table = 'time_statuses';

     // Define which fields are mass assignable
     protected $fillable = ['event_id', 'start_time', 'end_time'];
 
     // Set up the relationship with the Event model
     public function event()
     {
         return $this->belongsTo(Event::class);
     }
     // Accessor for start_time
    public function getStartTimeAttribute($value)
    {
        return Carbon::parse($value);
    }

    // Accessor for end_time
    public function getEndTimeAttribute($value)
    {
        return Carbon::parse($value);
    }
}
