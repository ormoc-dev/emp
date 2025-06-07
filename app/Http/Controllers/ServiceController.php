<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    //

    public function index()
    {
        // Remove cache temporarily for debugging
        $events = Event::with('timeSchedule')
            // ->where('date_start', '>=', now()) // Commented out temporarily
            ->orderBy('date_start', 'asc')
            // ->take(3) // Removed limit temporarily
            ->get();

        // Log the number of events found
        Log::info('Number of events found: ' . $events->count());

        return view('events', compact('events'));
    }
}
