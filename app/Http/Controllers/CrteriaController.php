<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\View;
use App\Models\Score;
use App\Models\TopContestant;
use App\Models\Round;
use App\Models\MinorAward;
use App\Models\TimeStatus;
use App\Models\VotingCategory;
use App\Models\Users_vote;
class CrteriaController extends Controller
{

    public function create($eventId)
{
    // Find the event
    $timeStatus = TimeStatus::where('event_id', $eventId)->first();
    $event = Event::findOrFail($eventId);
    $minorAwards = MinorAward::where('event_id', $eventId)->get();
    
    // Get rounds associated with the event
    $rounds = $event->rounds;

    // Fetch criteria associated with the rounds
    $criteria = Criteria::whereIn('round_id', $rounds->pluck('id'))
        ->with('round')
        ->get();

    // Fetch voting categories for this event
    $votingCategories = VotingCategory::where('event_id', $eventId)
        ->orderBy('created_at', 'desc')
        ->get();

    // Get total votes count
    $totalVotes = Users_vote::where('event_id', $eventId)->count();

    // Get or create voting settings
    $votingSettings = (object)[
        'max_votes_per_user' => 100, // Default value
        'vote_cost' => 5 // Default value
    ];

    // Fetch all events (if needed)
    $events = Event::all();

    return view('admin_dashboard.Categories.add_Criteria', compact(
        'event',
        'rounds',
        'events',
        'criteria',
        'minorAwards',
        'timeStatus',
        'votingCategories',
        'votingSettings',
        'totalVotes'
    ));
}



    public function updateDescription(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'event_id' => 'required|exists:events,id',
            'round_number' => 'required|integer|min:1',
            'round_description' => 'required|string|max:255',
            'top_contestants' => 'required|integer|min:1',
        ]);
    
        // Find the round based on event_id and round_number
        $round = Round::where('event_id', $validatedData['event_id'])
            ->where('round_number', $validatedData['round_number'])
            ->first();
    
            if ($round) {
                // Update the round's description and number of top contestants
                $round->update([
                    'round_description' => $validatedData['round_description'],
                    'top_contestants' => (int) $validatedData['top_contestants'], // Ensure it's cast to integer
                ]);
            
                // Logic to determine top contestants based on scores
                $topContestants = Score::where('round_id', $round->id)
                    ->orderByDesc('rate') // Assuming 'rate' is the score field
                    ->take($validatedData['top_contestants'])
                    ->get();
            
                // Store the top contestants in the 'top_contestants' table
                foreach ($topContestants as $contestant) {
                    TopContestant::create([
                        'round_id' => $round->id,
                        'contestant_id' => $contestant->contestant_id,
                        'score' => $contestant->rate, // Optionally store the score itself
                    ]);
                }
            
                return redirect()->back()->with('success', 'Round description and top contestants updated successfully.');
            } else {
                // If round is not found, return an error message
                return redirect()->back()->with('error', 'Round not found.');
            }
    }
    




    public function addCriteria(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'round_id' => 'required|exists:rounds,id',
            'criteria_description' => 'required',
            'highest_rate' => 'required|numeric',
            'lowest_rate' => 'required|numeric',
        ]);

        // Create criteria
        $criteria = Criteria::create([
            'round_id' => $request->input('round_id'),
            'criteria_description' => $request->input('criteria_description'),
            'highest_rate' => $request->input('highest_rate'),
            'lowest_rate' => $request->input('lowest_rate'),
        ]);

        // Store the selected round_id in the session
        session(['round_id' => $request->round_id]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Criteria added successfully!');
    }


    public function destroy(Criteria $criterion)
    {
        try {
            // Store the selected round_id in the session
            session(['round_id' => $criterion->round_id]);

            $criterion->delete();
            return redirect()->back()->with('successDelete', 'Criterion deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the criterion.');
        }
    }
}
