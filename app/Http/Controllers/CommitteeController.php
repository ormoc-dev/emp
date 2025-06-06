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
            $request->validate([
                'event_id' => 'required|exists:events,id',
                'round_id' => 'required|exists:rounds,id',
                'criteria_id' => 'required|exists:criteria,id',
                'scores' => 'required|array',
                'scores.*.*' => 'required|numeric|min:1|max:10'
            ]);

            $scores = [];
            foreach ($request->scores as $contestant_id => $judgeScores) {
                foreach ($judgeScores as $judge_id => $score) {
                    $scores[] = [
                        'contestant_id' => $contestant_id,
                        'user_id' => $judge_id,
                        'round_id' => $request->round_id,
                        'criteria_id' => $request->criteria_id,
                        'event_id' => $request->event_id,
                        'rate' => $score,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }

            Score::insert($scores);

            return redirect()->back()->with('success', 'Scores saved successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error saving scores: ' . $e->getMessage());
        }
    }

    public function getScores(Request $request)
    {
        $scores = Score::where('event_id', $request->event_id)
            ->where('round_id', $request->round_id)
            ->where('criteria_id', $request->criteria_id)
            ->where('user_id', auth()->id())
            ->get();

        return response()->json($scores);
    }

    public function updateScores(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'round_id' => 'required|exists:rounds,id',
            'criteria_id' => 'required|exists:criteria,id',
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:1|max:10'
        ]);

        foreach ($request->scores as $contestant_id => $rate) {
            Score::updateOrCreate(
                [
                    'contestant_id' => $contestant_id,
                    'user_id' => auth()->id(),
                    'round_id' => $request->round_id,
                    'criteria_id' => $request->criteria_id,
                    'event_id' => $request->event_id,
                ],
                ['rate' => $rate]
            );
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
