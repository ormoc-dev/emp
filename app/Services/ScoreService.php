<?php

namespace App\Services;

use App\Models\RoundResult;
use App\Models\Score;
use App\Models\Round;
use App\Models\Contestant;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use App\Models\MinorAwardScore;
use App\Models\MinorAwardSetting;
use App\Models\overall_Minoraward_scores;


class ScoreService
{
    public function calculateFinalScores($eventId)
    {
        $contestants = Contestant::with(['scores', 'scores.round', 'scores.criteria'])
            ->where('event_id', $eventId)
            ->get();
        $results = [];

        foreach ($contestants as $contestant) {
            $totalScore = 0;
            $weightSum = 0;
            $roundScores = [];
            $criteriaScores = [];

            foreach ($contestant->scores as $score) {
                $roundId = $score->round->id;
                $criterionId = $score->criteria->id;
                $roundWeight = $this->getRoundWeight($roundId);
                $totalScore += $score->rate * $roundWeight;
                $weightSum += $roundWeight;

                if (!isset($roundScores[$roundId])) {
                    $roundScores[$roundId] = [];
                }
                $roundScores[$roundId][$criterionId] = $score->rate;

                if (!isset($criteriaScores[$criterionId])) {
                    $criteriaScores[$criterionId] = [];
                }
                $criteriaScores[$criterionId][$roundId] = $score->rate;
            }

            $finalScore = $weightSum ? $totalScore / $weightSum : 0;

            $results[] = [
                'contestant_id' => $contestant->id,
                'name' => $contestant->name,
                'final_score' => $finalScore,
                'round_scores' => $roundScores,
                'criteria_scores' => $criteriaScores,
            ];
        }

        usort($results, function ($a, $b) {
            return $b['final_score'] <=> $a['final_score'];
        });

        return $results;
    }

    private function getRoundWeight($roundId)
    {
        $weights = [
            1 => 0.30,
            2 => 0.20,
            3 => 0.25,
            4 => 0.15,
            5 => 0.10,
        ];

        return $weights[$roundId] ?? 1;
    }

    public function determineTopContestants($roundId)
    {
        $round = Round::findOrFail($roundId);


        $previousRound = Round::where('event_id', $round->event_id)
            ->where('round_number', '<', $round->round_number)
            ->orderBy('round_number', 'desc')
            ->first();


        if ($previousRound) {
            $qualifiedContestants = RoundResult::where('round_id', $previousRound->id)
                ->where('qualified', true)
                ->pluck('contestant_id');
        } else {

            $qualifiedContestants = Contestant::where('event_id', $round->event_id)
                ->pluck('id');
        }

        $scores = Score::where('round_id', $roundId)
            ->whereIn('contestant_id', $qualifiedContestants)
            ->select('contestant_id', DB::raw('SUM(rate) as total_score'))
            ->groupBy('contestant_id')
            ->orderBy('total_score', 'desc')
            ->take($round->top_contestants)
            ->get();

        foreach ($scores as $score) {
            RoundResult::updateOrCreate(
                ['round_id' => $roundId, 'contestant_id' => $score->contestant_id],
                ['total_score' => $score->total_score, 'qualified' => true]
            );
        }


        return $scores->pluck('contestant_id')->toArray();
    }



    public function calculateOverallMinorAwardScores($eventId)
    {
        $overallScores = MinorAwardScore::where('event_id', $eventId)
            ->select('contestant_id', DB::raw('SUM(rate) as overall_score'))
            ->groupBy('contestant_id')
            ->get();

        foreach ($overallScores as $score) {
            overall_Minoraward_scores::updateOrCreate(
                [
                    'contestant_id' => $score->contestant_id,
                    'event_id' => $eventId,
                ],
                [
                    'overall_score' => $score->overall_score,
                ]
            );
        }
    }

    public function getTopContestantsByMinorAwards($eventId)
    {
        // Retrieve the top contestant limit from the minor_awards_settings table
        $topContestantLimit = DB::table('minor_awards_settings')
            ->where('event_id', $eventId)
            ->value('top_contestant_limit');

        // Default to 9 if no limit is set
        $limit = $topContestantLimit ?? null;

        // Retrieve top contestants based on the specified limit
        $topContestants = MinorAwardScore::where('event_id', $eventId)
            ->select('contestant_id', DB::raw('SUM(rate) as total_score'))
            ->groupBy('contestant_id')
            ->orderBy('total_score', 'desc')
            ->take($limit)  // Dynamically set the limit here
            ->get();

        // Get the first round of the event
        $firstRound = Round::where('event_id', $eventId)->orderBy('round_number')->first();

        // Assign the top contestants to the first round and update the RoundResult
        foreach ($topContestants as $contestant) {
            RoundResult::updateOrCreate(
                ['round_id' => $firstRound->id, 'contestant_id' => $contestant->contestant_id],
                [
                    'total_score' => $contestant->total_score,
                    'qualified' => true,
                ]
            );
        }

        // Return the IDs of the top contestants
        return $topContestants->pluck('contestant_id')->toArray();
    }
}
