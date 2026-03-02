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
use App\Models\User;

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

        // Get contestants for this event
        $contestants = $event->contestants()
            ->orderBy('number')
            ->get();

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

        // Get judges assigned to this specific event
        $judges = $event->judges()->where('level', 'judge')->get();

        return view('admin_dashboard.Categories.add_Criteria', compact(
            'event',
            'rounds',
            'events',
            'criteria',
            'minorAwards',
            'timeStatus',
            'votingCategories',
            'votingSettings',
            'totalVotes',
            'contestants',
            'judges'
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

    public function edit(Criteria $criterion)
    {
        // Check if user is authenticated and authorized
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Please log in.'
            ], 401);
        }
        
        // Check if the criterion exists and is loaded properly
        if (!$criterion || !$criterion->exists) {
            return response()->json([
                'success' => false,
                'message' => 'Criteria not found.'
            ], 404);
        }
        
        // Return the criteria data as JSON for the edit modal
        return response()->json([
            'success' => true,
            'criterion' => [
                'id' => $criterion->id,
                'round_id' => $criterion->round_id,
                'event_id' => $criterion->round->event_id,
                'criteria_description' => $criterion->criteria_description,
                'highest_rate' => $criterion->highest_rate,
                'lowest_rate' => $criterion->lowest_rate,
                'hidden_judge_ids' => $criterion->hiddenJudges()->pluck('users.id')->toArray(),
            ]
        ]);
    }

    public function update(Request $request, Criteria $criterion)
    {
        // Check if user is authenticated and authorized
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Please log in.'
            ], 401);
        }
        
        // Validate the incoming request data
        $validatedData = $request->validate([
            'round_id' => 'required|exists:rounds,id',
            'criteria_description' => 'required',
            'highest_rate' => 'required|numeric',
            'lowest_rate' => 'required|numeric',
        ]);

        // Update the criteria
        $criterion->update([
            'round_id' => $request->input('round_id'),
            'criteria_description' => $request->input('criteria_description'),
            'highest_rate' => $request->input('highest_rate'),
            'lowest_rate' => $request->input('lowest_rate'),
        ]);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Criteria updated successfully!',
            'criterion' => $criterion
        ]);
    }

    public function getProductionScores(Request $request, Criteria $criterion)
    {
        // Check if user is authenticated and authorized
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Please log in.'
            ], 401);
        }
        
        $judgeId = $request->query('judge_id');
        
        // Get all contestants for the event associated with this criteria's round
        $round = $criterion->round;
        $event = $round->event;
        $contestants = $event->contestants()->orderBy('number')->get();
        
        $scores = [];
        foreach ($contestants as $contestant) {
            $query = Score::where('contestant_id', $contestant->id)
                ->where('criteria_id', $criterion->id)
                ->where('round_id', $round->id)
                ->where('event_id', $event->id);

            if ($judgeId) {
                $query->where('user_id', $judgeId);
            } else {
                $query->where('user_id', auth()->id());
            }

            $score = $query->first();
            
            $scores[] = [
                'contestant_id' => $contestant->id,
                'contestant_number' => $contestant->number,
                'contestant_name' => $contestant->name,
                'score' => $score ? $score->rate : null
            ];
        }
        
        return response()->json([
            'success' => true,
            'scores' => $scores,
            'lowest_rate' => $criterion->lowest_rate,
            'highest_rate' => $criterion->highest_rate
        ]);
    }

    public function updateProductionScore(Request $request, Criteria $criterion, $contestantId)
    {
        // Check if user is authenticated and authorized
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access. Please log in.'
            ], 401);
        }
        
        $request->validate([
            'score' => 'required|numeric|min:' . $criterion->lowest_rate . '|max:' . $criterion->highest_rate
        ]);
        
        // Find or create the score record
        $score = Score::updateOrCreate(
            [
                'contestant_id' => $contestantId,
                'criteria_id' => $criterion->id,
                'round_id' => $criterion->round_id,
                'event_id' => $criterion->round->event_id,
                'user_id' => $request->input('user_id') ?? auth()->id(),
            ],
            [
                'rate' => $request->score
            ]
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Production score updated successfully',
            'score' => $score
        ]);
    }

    public function getMinorAwardScores($eventId)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $event = \App\Models\Event::findOrFail($eventId);
        $contestants = $event->contestants()->orderBy('number')->get();
        $minorAwards = \App\Models\MinorAward::where('event_id', $eventId)->get();

        // Key existing scores by [minor_award_id][contestant_id] => avg rate across judges
        $rawScores = \App\Models\MinorAwardScore::where('event_id', $eventId)
            ->get()
            ->groupBy('minor_award_id');

        $result = [];
        foreach ($minorAwards as $award) {
            $awardScores = $rawScores->get($award->id, collect());
            // Average per contestant across judges
            $perContestant = $awardScores->groupBy('contestant_id')
                ->map(fn($rows) => round($rows->avg('rate'), 4));

            $rows = [];
            foreach ($contestants as $c) {
                $rows[] = [
                    'contestant_id'     => $c->id,
                    'contestant_number' => $c->number,
                    'contestant_name'   => $c->name,
                    'avg_score'         => $perContestant->get($c->id),
                ];
            }
            $result[] = [
                'id'          => $award->id,
                'name'        => $award->minor_awards_description,
                'high_rate'   => $award->high_rate,
                'low_rate'    => $award->low_rate,
                'contestants' => $rows,
            ];
        }

        return response()->json(['success' => true, 'minor_awards' => $result]);
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

    public function toggleVisibility(Criteria $criteria)
    {
        $criteria->is_hidden = !$criteria->is_hidden;
        $criteria->save();

        return response()->json([
            'success' => true,
            'is_hidden' => $criteria->is_hidden
        ]);
    }

    public function setHiddenJudges(Request $request, Criteria $criteria)
    {
        $validated = $request->validate([
            'judge_ids' => 'array',
            'judge_ids.*' => 'exists:users,id'
        ]);

        $judgeIds = $validated['judge_ids'] ?? [];
        $criteria->hiddenJudges()->sync($judgeIds);

        return response()->json([
            'success' => true,
            'message' => 'Hidden judges updated',
            'judge_ids' => $judgeIds
        ]);
    }
}
