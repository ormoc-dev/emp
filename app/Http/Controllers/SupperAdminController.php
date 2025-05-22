<?php
namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
class SupperAdminController extends Controller
{
    public function Sadmin_index(Request $request) 
    {
        // Get basic stats
        $admin = User::where('level', 'admin')->get();

        // Get event analytics data
        $eventAnalytics = Event::select(
            'event_year as year',
            DB::raw('COUNT(*) as total_events'),
            DB::raw('SUM(views_count) as total_views'),
            DB::raw('COUNT(CASE WHEN event_status = "pending" THEN 1 END) as pending_events'),
            DB::raw('COUNT(CASE WHEN event_status = "completed" THEN 1 END) as completed_events')
        )
        ->groupBy('event_year')
        ->orderBy('event_year')
        ->get();

        return view('SupperAdmin_dashboard.SupAdmin_home', [
            'admin' => $admin,
            'usersCount' => User::count(),
            'ContestantCount' => Contestant::count(),
            'judgeCount' => User::where('level', 'judge')->count(),
            'TabulatorCount' => User::where('level', 'admin')->count(),
            'eventYears' => $eventAnalytics->pluck('year'),
            'eventCounts' => $eventAnalytics->pluck('total_events'),
            'eventViews' => $eventAnalytics->pluck('total_views'),
            'pendingEvents' => $eventAnalytics->pluck('pending_events'),
            'completedEvents' => $eventAnalytics->pluck('completed_events'),
        ]);
    }
    public function getFeedbacks() {
        // Fetch the latest 10 feedbacks, adjust as needed
        $feedbacks = Feedback::orderBy('created_at', 'desc')->take(10)->get();

        return response()->json($feedbacks);
    }

  
}