<?php

namespace App\Http\Controllers;

use App\Models\EventHighlight;
use Illuminate\Http\Request;

class EventHighlightController extends Controller
{
    public function index()
    {
        
        return view('SupperAdmin_dashboard.pages.EventHighlight');
    }

 
}