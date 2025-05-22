<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_subtitle',
        'event_status',
        'event_rounds',
        'event_year',
        'date_start',
        'date_end',
        'event_venue',
         'user_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function minorAwards()
    {
        return $this->hasMany(MinorAward::class); // Assuming MinorAward is another model
    }
    public function rounds()
    {
        return $this->hasMany(Round::class);
    }
   
    
    public function criteria()
    {
        return $this->hasMany(Criteria::class);
    } 
    
        public function contestants()
        {
            return $this->hasMany(Contestant::class);
        }

        public function judges()
        {
            return $this->belongsToMany(User::class, 'event_judge', 'event_id', 'judge_id');
        }
        
        public function comments()
        {
            return $this->hasMany(Comment::class);
        }
        public function timeStatus()
        {
            return $this->hasOne(TimeStatus::class);
        }

        public function events_judge()
        {
            return $this->belongsToMany(Event::class, 'event_judge', 'judge_id', 'event_id');
        }

        public function timeSchedule()
        {
            return $this->hasOne(TimeSchedule::class, 'event_id');
        }

        public function votingCategories(): HasMany
        {
            return $this->hasMany(VotingCategory::class);
        }
    
        // Get votes for a specific category
        public function getVotesByCategory($categoryId)
        {
            return $this->votes()
                ->whereHas('category', function($query) use ($categoryId) {
                    $query->where('id', $categoryId);
                });
        }

        public function liveLink()
        {
            return $this->hasOne(LiveLink::class, 'event_id');
        }
}
