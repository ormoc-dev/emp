<?php

namespace App\Http\Controllers;

use App\Models\LiveLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LiveLinkController extends Controller
{
    public function store(Request $request, $eventId)
    {
        $request->validate([
            'fb_embed_link' => 'required|url'
        ]);

        try {
            LiveLink::updateOrCreate(
                ['event_id' => $eventId],
                ['fb_embed_link' => $request->fb_embed_link]
            );

            return redirect()->back()->with('success', 'Live stream link has been saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving live link: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to save live stream link. Please try again.');
        }
    }

    public function destroy($eventId)
    {
        try {
            $liveLink = LiveLink::where('event_id', $eventId)->first();
            
            if (!$liveLink) {
                return redirect()->back()->with('error', 'Live stream link not found.');
            }

            $liveLink->delete();
            return redirect()->back()->with('success', 'Live stream link has been removed successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting live link: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to remove live stream link. Please try again.');
        }
    }
}