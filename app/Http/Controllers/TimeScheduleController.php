<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\TimeSchedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
class TimeScheduleController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'time_start' => 'required|date',
            'time_end' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $start = Carbon::parse($request->time_start);
                    $end = Carbon::parse($value);
                    
                    if ($end->lte($start)) {
                        $fail('The end time must be after the start time.');
                    }
                    
                    // Optional: Add maximum duration limit if needed
                    // if ($end->diffInDays($start) > 30) {
                    //     $fail('The schedule cannot exceed 30 days.');
                    // }
                }
            ]
        ]);

        // Delete existing schedule if exists
        if ($event->timeSchedule) {
            $event->timeSchedule->delete();
        }

        // Create new schedule with the full datetime values
        $timeSchedule = $event->timeSchedule()->create([
            'time_start' => Carbon::parse($request->time_start),
            'time_end' => Carbon::parse($request->time_end),
        ]);

        return redirect()->back()->with('success', 'Time schedule has been set successfully.');
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'time_start' => 'required|date',
            'time_end' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $start = Carbon::parse($request->time_start);
                    $end = Carbon::parse($value);
                    
                    if ($end->lte($start)) {
                        $fail('The end time must be after the start time.');
                    }
                }
            ]
        ]);

        if (!$event->timeSchedule) {
            return redirect()->back()->with('error', 'No schedule found for this event.');
        }

        $event->timeSchedule->update([
            'time_start' => Carbon::parse($request->time_start),
            'time_end' => Carbon::parse($request->time_end),
        ]);

        return redirect()->back()->with('success', 'Time schedule has been updated successfully.');
    }

    public function destroy(Event $event)
    {
        if ($event->timeSchedule) {
            $event->timeSchedule->delete();
            return redirect()->back()->with('success', 'Time schedule has been removed.');
        }

        return redirect()->back()->with('error', 'No schedule found for this event.');
    }
}