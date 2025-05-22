<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MinorAward;
class MinorAwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_minor_awards(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'minor_awards_description' => 'required|string',
            'high_rate' => 'required|numeric',
            'low_rate' => 'required|numeric',
        ]);

        // Create a new MinorAward entry
        $minorAward = MinorAward::create([
            'event_id' => $request->route('event'), // Use the event ID from the route
            'minor_awards_description' => $request->input('minor_awards_description'),
            'high_rate' => $request->input('high_rate'),
            'low_rate' => $request->input('low_rate'),
        ]);

        // Return JSON response
        return response()->json([
            'success' => true,
            'minor_award' => $minorAward
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        // Find the MinorAward entry by ID
        $minorAward = MinorAward::find($id);
    
        if ($minorAward) {
            // Delete the MinorAward entry
            $minorAward->delete();
    
            // Return a JSON response indicating success
            return response()->json([
                'success' => true,
                'message' => 'Minor Award deleted successfully.'
            ]);
        } else {
            // Return a JSON response indicating the record was not found
            return response()->json([
                'success' => false,
                'message' => 'Minor Award not found.'
            ], 404);
        }
    }
    
}
