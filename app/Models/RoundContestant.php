<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoundContestant extends Model
{
    use HasFactory;

     // Specify the table name if it doesn't follow Laravel's naming convention
     protected $table = 'round_contestant';

     // Specify the fillable fields
     protected $fillable = [
         'round_id',
         'contestant_id'
     ];
 
     // Define relationships
     public function round()
     {
         return $this->belongsTo(Round::class);
     }
 
     public function contestant()
     {
         return $this->belongsTo(Contestant::class);
     }
}
