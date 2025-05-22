<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ST_or_PD extends Controller
{
    //

    public function SP(Request $request){


       


        $events = Event::where('user_id', Auth::id())
        ->orderBy('event_name', 'desc')
        ->get();


        return view('admin_dashboard.ST_OR_PD',compact('events'));
    }


    public function toggleStatusSP(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        // Toggle event status
        if ($event->event_status == 'pending') {
            $event->event_status = 'started';
            $message = 'Event "' . $event->event_name . '" started successfully.';
        } else {
            $event->event_status = 'pending';
            $message = 'Event "' . $event->event_name . '" status reverted to pending.';
        }

        $event->save();

        // Redirect back to the previous page
        return redirect()->back()->with('success', $message);
    }

}
