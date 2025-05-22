<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Judge;
use App\Models\Contestant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Users_vote;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\EventJudge;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getEvents()
{
    $events = Event::where('user_id', Auth::id())
        ->orderBy('date_start', 'desc')
        ->get();

       
       
    return response()->json($events);
}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function users_index()
{
    $events = Event::with([
        'contestants', 
        'votingCategories', 
        'liveLink',
        'judges' => function($query) {
            $query->where('users.level', '=', 'judge');
        }
    ])->get();
    
    $voteCounts = Users_vote::select('event_id', DB::raw('count(*) as total_votes'))
        ->groupBy('event_id')
        ->pluck('total_votes', 'event_id');
    
    // Debug log
    Log::info('Events with live links:', [
        'events' => $events->map(function($event) {
            return [
                'id' => $event->id,
                'live_link' => $event->liveLink ? $event->liveLink->fb_embed_link : null
            ];
        })
    ]);
    
    return view('users_dashboard.users_home', compact('events', 'voteCounts'));
}


    public function admin_index(Request $request)
    {
        // Get events for the authenticated user only
        $events = Event::where('user_id', Auth::id())
            ->orderBy('date_start', 'desc')
            ->paginate(10);
            
        $pendingEvents = Event::where('user_id', Auth::id())
            ->where('event_status', 'pending')
            ->get();
    
        return view('admin_dashboard.admin_home', [
            'pendingEvents' => $pendingEvents,
            'events' => $events,
            'eventsCount' => Event::where('user_id', Auth::id())->count(),
            'contestantsCount' => Contestant::whereIn('event_id', Event::where('user_id', Auth::id())->pluck('id'))->count(),
            'usersCount' => User::whereNull('level')->orWhere('level', 'user')->count(),
        ]);
    }

    public function judges_index()
    {
        // Pass the events data to the view
        return view('judge_dashboard.judge_panel');
    }

   
}
