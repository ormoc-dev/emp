<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'created_by',
        'profile',
        'last_active_at',
        'remaining_votes',
        'payment_reference',
        'biography',
        'achievements',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_active_at' => 'datetime',
    ];
   
     

    public function events_judge()
    {
        return $this->belongsToMany(Event::class, 'event_judge', 'judge_id', 'event_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_judge', 'judge_id', 'event_id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    public function Judges($query)
    {
        return $query->where('level', 'judge');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getIsOnlineAttribute()
    {
        return $this->last_active_at && $this->last_active_at->gt(Carbon::now()->subMinutes(1));
    }

    public function votes()
{
    return $this->hasMany(Users_vote::class, 'user_id');
}

public function paypalTransactions()
    {
        return $this->hasMany(PaypalTransaction::class);
    }
}
