<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\EventJudge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class EventJudgeController extends Controller
{




    public function store_judge_event(Request $request)
    {
        $eventIds = $request->input('events', []);
        $judgeIds = $request->input('judges', []);
    
        // Verify these events belong to the authenticated user
        $authorizedEvents = Event::where('user_id', Auth::id())
            ->whereIn('id', $eventIds)
            ->get();
    
        if ($authorizedEvents->isEmpty()) {
            return redirect()->route('register_judge')
                ->with('error', 'No authorized events selected');
        }
    
        foreach ($authorizedEvents as $event) {
            $event->judges()->syncWithoutDetaching($judgeIds);
        }
    
        return redirect()->route('register_judge')
            ->with('success', 'Judges assigned to events successfully');
    }
    
    public function register_judge(Request $request)
    {
        // Retrieve events that are not started and belong to the authenticated user
        $events = Event::where('user_id', Auth::id())
            ->where('event_status', '!=', 'started')
            ->get();
    
        // Retrieve selected event_id from request
        $selectedEventId = $request->input('event_id');
    
        // Verify selected event belongs to authenticated user
        if ($selectedEventId) {
            $eventBelongsToUser = Event::where('user_id', Auth::id())
                ->where('id', $selectedEventId)
                ->exists();
            
            if (!$eventBelongsToUser) {
                $selectedEventId = null;
            }
        }
    
        // Retrieve judges created by the current admin
        $judgesQuery = User::where('level', 'judge')
            ->where('created_by', Auth::id());  // Add this line to filter judges
    
        if ($selectedEventId) {
            // Get judge IDs already assigned to the selected event
            $assignedJudgeIds = DB::table('event_judge')
                ->where('event_id', $selectedEventId)
                ->pluck('judge_id');
    
            // Exclude judges already assigned to the selected event
            $judgesQuery->whereNotIn('id', $assignedJudgeIds);
        }
    
        // Get all judges without pagination
        $judges = $judgesQuery->get();
    
        // Get event IDs that belong to the authenticated user
        $userEventIds = $events->pluck('id')->toArray();
    
        // Retrieve event-judge relationships only for user's events
        $eventJudges = EventJudge::whereIn('event_id', $userEventIds)
            ->with(['event', 'judge'])
            ->get();
    
        return view('admin_dashboard.Categories.add_judge', compact(
            'events',
            'judges',
            'eventJudges',
            'selectedEventId'
        ));
    }

    public function getAvailableJudges(Request $request)
    {
        $event_id = $request->input('event_id');

        // Get judge IDs already assigned to the selected event
        $assignedJudgeIds = DB::table('event_judge')->where('event_id', $event_id)->pluck('judge_id');

        // Retrieve judges not assigned to the selected event
        $availableJudges = User::where('level', 'judge')->whereNotIn('id', $assignedJudgeIds)->get();

        return response()->json($availableJudges);
    }




    public function destroy($id)
    {
        try {
            Log::info('Destroy method called for ID: ' . $id);
            $eventJudge = EventJudge::findOrFail($id);
            $eventJudge->delete();
            return response()->json([
                'success' => true,
                'message' => 'Event judge deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting event judge: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error deleting event judge'
            ], 500);
        }
    }

    public function multipleDestroy(Request $request)
    {
        Log::info('Multiple destroy method called');
        Log::info($request->all());

        $ids = $request->input('selected_items', []);
        Log::info('IDs to delete: ' . implode(', ', $ids));

        $deletedCount = EventJudge::whereIn('id', $ids)->delete();

        Log::info('Deleted count: ' . $deletedCount);

        return redirect()->back()->with('success', $deletedCount . ' assignments have been deleted successfully.');
    }
}
