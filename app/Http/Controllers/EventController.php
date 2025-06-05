<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Round;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{


    public function create()
    {
        $events = Event::where('user_id', Auth::id())
            ->orderBy('event_name', 'desc')
            ->get();

        if (request()->ajax()) {
            return response()->json(['events' => $events]);
        } else {
            return View::make('admin_dashboard.Categories.add_event', ['events' => $events]);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_name' => 'required|string',
            'event_subtitle' => 'required|string',
            'event_rounds' => 'required|integer',
            'event_year' => 'required|integer',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'event_venue' => 'required|string',
        ]);

        // Add the user_id to the validated data
        $validatedData['user_id'] = Auth::id();

        $event = Event::create($validatedData);

        // Create rounds
        $roundsCount = $request->input('event_rounds');
        for ($i = 1; $i <= $roundsCount; $i++) {
            Round::create([
                'event_id' => $event->id,
                'round_number' => $i,
            ]);
        }

        return response()->json(['success' => 'submitted successfully', 'event' => $event]);
    }


    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('success', 'Event  Deleted Successfully');
    }


    public function toggleStatus(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        if ($event->event_status == 'pending') {
            $event->event_status = 'started';
            $message = 'Event "' . $event->event_name . '" started successfully.';
        } else {
            $event->event_status = 'pending';
            $message = 'Event "' . $event->event_name . '" status reverted to pending.';
        }

        $event->save();
        return redirect()->back()->with('success', $message);
    }


    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());

        return response()->json([
            'status' => 'success',
            'event' => $event,
            'message' => 'Event updated successfully!',
        ]);
    }
}
