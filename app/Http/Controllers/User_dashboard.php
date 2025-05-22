<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Vote;
use App\Models\Comment;
use App\Models\Purchase;    
use App\Models\User;
class User_dashboard extends Controller
{



   
    public function users_history()
    {
        $user = User::find(auth()->id());
        $votes = $user->votes()
            ->with(['contestant', 'event'])
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Get user's payment history
        $payments = $user->paypalTransactions()
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('users_dashboard.users_history', compact('votes', 'payments'));
    }
    public function users_home_page()
    {
        // Eager load both contestants and timeStatus relationships
        $events = Event::with(['contestants'])->get();
    
        return view('users_dashboard.users_home', compact('events'));
    }
    
    public function showContestants_user($id)
    {
        $event = Event::with(['contestants', 'timeSchedule'])->find($id);
    
        if (!$event) {
            abort(404, 'Event not found');
        }
    
        return view('users_dashboard.vote_contestants', compact('event'));
    }


















    public function profile()
    {
        return view('users_dashboard.profile_info');
    }






    public function pricing_vote()
    {
        return view('users_dashboard.pricing_vote');
    }
}
