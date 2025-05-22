<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinorAward extends Model
{
    use HasFactory;

   
   protected $fillable = [
       'event_id',
       'minor_awards_description',
       'high_rate',
       'low_rate',
   ];

   public function event()
   {
       return $this->belongsTo(Event::class);
   }
   public function scores()
   {
       return $this->hasMany(MinorAwardScore::class);
   }
}
