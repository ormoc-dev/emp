<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JudgeScores;
use App\Models\Event;
use App\Models\MinorAward;
use App\Models\Round;
class JudgeScoresController extends Controller
{
    //

    public function showMinorAwards($eventId)
    {
        $event = Event::with('contestants')->findOrFail($eventId);
        $minorAwards = MinorAward::where('event_id', $eventId)->get();
        return view('judge_dashboard.MinorRate.minor_rate', compact('event', 'minorAwards'));
    }

    
}
