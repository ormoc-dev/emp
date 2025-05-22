<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Cache;
class ServiceController extends Controller
{
    //

    public function index()
{
    $events = Cache::remember('events', 60, function () {
        return Event::with('timeSchedule')
            ->where('date_start', '>=', now())
            ->orderBy('date_start', 'asc')
            ->take(3)
            ->get();
    });

    return view('events', compact('events'));
}

}
