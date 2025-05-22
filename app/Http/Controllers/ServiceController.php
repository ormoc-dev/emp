<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
class ServiceController extends Controller
{
    //

    public function index()
    {
        $events = Event::with('timeSchedule')
            ->where('date_start', '>=', now())
            ->orderBy('date_start', 'asc')
            ->take(3)
            ->get();
         return view('Service', compact('events'));
    }
}
