<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveLink extends Model
{
    use HasFactory;
    protected $table = '_live_link';
    
    protected $fillable = [
        'fb_embed_link',
        'event_id'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
