<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'event_date',
        'category',
        'is_active',
        'display_order'
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean'
    ];
}
