<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinorAwardSetting extends Model
{
    use HasFactory;

    protected $table = 'minor_awards_settings';


    protected $fillable = ['event_id', 'top_contestant_limit'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
