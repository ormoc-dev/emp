<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\MinorAwardSetting;

class MinorAwardSettingController extends Controller
{
    public function updateTopContestants(Request $request, $eventId)
    {
        // Validate the input
        $validated = $request->validate([
            'top_contestant_limit' => 'required|integer|min:1',
        ]);

        // Update or create the setting for the event
        $setting = MinorAwardSetting::updateOrCreate(
            ['event_id' => $eventId],
            ['top_contestant_limit' => $validated['top_contestant_limit']]
        );

        // Return the updated value in the response
        return response()->json([
            'success' => true,
            'top_contestant_limit' => $setting->top_contestant_limit
        ]);
    }
}
