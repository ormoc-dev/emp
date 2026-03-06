<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Score;
use App\Models\Event;
use App\Models\Contestant;
use App\Models\Round;
use App\Models\Criteria;
use App\Models\Committee;
use Illuminate\Http\Request;

class CommitteeController extends Controller
{
    public function storeScores(Request $request)
    {
        try {
            $weight = (float) $request->input('committee_weight', 0);
            $selectedJudges = $request->input('selected_judges', []);

            if (empty($selectedJudges)) {
                return redirect()->back()->with('error', 'No judges selected for committee.');
            }

            $scoresToInsert = [];
            foreach ($request->scores as $contestant_id => $judgeScores) {
                // Filter judgeScores to only include selected judges
                $filteredScores = array_filter($judgeScores, function($judge_id) use ($selectedJudges) {
                    return in_array($judge_id, $selectedJudges);
                }, ARRAY_FILTER_USE_KEY);

                if (empty($filteredScores)) continue;

                // Calculate average of selected judges
                $sum = array_sum($filteredScores);
                $count = count($filteredScores);
                $average = $sum / $count;

                // Calculate weighted score: (Average / 10) * Weight
                $weightedScore = ($average / 10) * $weight;

                // Store the WEIGHTED score for each selected judge
                foreach ($filteredScores as $judge_id => $rawScore) {
                    $scoresToInsert[] = [
                        'contestant_id' => $contestant_id,
                        'user_id' => $judge_id,
                        'round_id' => $request->round_id,
                        'criteria_id' => $request->criteria_id,
                        'event_id' => $request->event_id,
                        'rate' => round($weightedScore, 2),
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }

            if (!empty($scoresToInsert)) {
                Score::insert($scoresToInsert);
            }

            return redirect()->back()->with('success', 'Scores saved successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error saving scores: ' . $e->getMessage());
        }
    }

    public function getScores(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'round_id' => 'required|exists:rounds,id',
            'criteria_id' => 'required|exists:criteria,id',
        ]);

        $scores = Score::where('event_id', $request->event_id)
            ->where('round_id', $request->round_id)
            ->where('criteria_id', $request->criteria_id)
            ->get();

        return response()->json($scores);
    }

    public function updateScores(Request $request)
    {
        $weight = (float) $request->input('committee_weight', 0);
        $selectedJudges = $request->input('selected_judges', []);

        if (empty($selectedJudges)) {
            return redirect()->back()->with('error', 'No judges selected for committee.');
        }

        foreach ($request->scores as $contestant_id => $judgeScores) {
            // Filter judgeScores to only include selected judges
            $filteredScores = array_filter($judgeScores, function($judge_id) use ($selectedJudges) {
                return in_array($judge_id, $selectedJudges);
            }, ARRAY_FILTER_USE_KEY);

            if (empty($filteredScores)) continue;

            // Calculate average of selected judges
            $sum = array_sum($filteredScores);
            $count = count($filteredScores);
            $average = $sum / $count;

            // Calculate weighted score: (Average / 10) * Weight
            $weightedScore = ($average / 10) * $weight;

            // Update the WEIGHTED score for each selected judge
            foreach ($filteredScores as $judge_id => $rawScore) {
                Score::updateOrCreate(
                    [
                        'contestant_id' => $contestant_id,
                        'user_id' => $judge_id,
                        'round_id' => $request->round_id,
                        'criteria_id' => $request->criteria_id,
                        'event_id' => $request->event_id,
                    ],
                    ['rate' => round($weightedScore, 2)]
                );
            }
        }

        return redirect()->back()->with('success', 'Scores updated successfully');
    }

    public function showCriteria(Event $event)
    {
        // Get contestants for this event
        $contestants = $event->contestants()
            ->orderBy('contestant_number')
            ->get();

        // Get rounds and criteria
        $rounds = $event->rounds;
        $criteria = $event->criteria;

        return view('admin_dashboard.Categories.add_Criteria', [
            'event' => $event,
            'contestants' => $contestants,
            'rounds' => $rounds,
            'criteria' => $criteria,
            'minorAwards' => $event->minorAwards,
            'votingCategories' => $event->votingCategories,
            'votingSettings' => $event->votingSettings,
            'totalVotes' => $event->totalVotes
        ]);
    }
}
