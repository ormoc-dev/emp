<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Contestant;
use Illuminate\Support\Facades\Auth;
class showEventsController extends Controller
{
    public function show_event_in_Contestant()
    {
        $events = Event::where('user_id', Auth::id())->orderBy('event_name', 'desc')->paginate(10);
        return View::make('admin_dashboard.Categories.SelectEvent.Select_Event_Contestants', ['events' => $events]);
    }
    public function show_event_in_judge()
    {
        $events = Event::orderBy('event_name', 'desc')->paginate(10);
        return View::make('admin_dashboard.Categories.SelectEvent.Select_Event_Judges', ['events' => $events]);
    }

    public function show_event_in_Criteria()
    {
        $events = Event::where('user_id', Auth::id())->orderBy('event_name', 'desc')->paginate(10);
        return View::make('admin_dashboard.Categories.SelectEvent.Select_Event_Criteria', ['events' => $events]);
    }
}
