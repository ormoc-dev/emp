<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Round;
use App\Models\Event;
use App\Models\Score;
use App\Models\Criteria;
use Illuminate\Http\Request;
use App\Services\ScoreService;
use App\Models\Contestant;
use App\Models\RoundResult;
use App\Models\RoundJudgeStatus;
use App\Models\MinorAward;
use App\Models\MinorAwardScore;

class ScoreController extends Controller
{
    protected $scoreService;

    public function __construct(ScoreService $scoreService)
    {
        $this->scoreService = $scoreService;
    }

    public function submitRates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'user_id' => 'required|exists:users,id',
            'round_id' => 'nullable|exists:rounds,id',
            'minor_award_id' => 'nullable|exists:minor_awards,id',
            'rates.*.contestant_id' => 'required|exists:contestants,id',
            'rates.*.criteria.*.rate' => 'required_if:round_id,not_null|numeric|min:0',
            'rates.*.rate' => 'required_if:minor_award_id,not_null|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validation error.');
        }

        $eventId = $request->input('event_id');
        $userId = $request->input('user_id');
        $roundId = $request->input('round_id');
        $minorAwardId = $request->input('minor_award_id');
        $rates = $request->input('rates');
    
        if ($minorAwardId) {
            foreach ($rates as $contestantRates) {
                $contestantId = $contestantRates['contestant_id'];
                $rate = $contestantRates['rate'];
    
                MinorAwardScore::updateOrCreate(
                    [
                        'contestant_id' => $contestantId,
                        'user_id' => $userId,
                        'minor_award_id' => $minorAwardId,
                        'event_id' => $eventId,
                    ],
                    ['rate' => $rate]
                );
            }
    
            $nextMinorAward = MinorAward::where('event_id', $eventId)
                ->whereDoesntHave('scores', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->first();
    
            if (!$nextMinorAward) {
                $this->scoreService->calculateOverallMinorAwardScores($eventId);
    
                $topContestants = $this->scoreService->getTopContestantsByMinorAwards($eventId);
    
                // Populate the first round with top contestants if available
                $firstRound = Round::where('event_id', $eventId)->orderBy('round_number')->first();
                if ($firstRound && !empty($topContestants)) {
                    $firstRound->contestants()->sync($topContestants);
                }
    
                return redirect()->route('voting_success', ['eventId' => $eventId])
                    ->with('success', 'All minor awards rated, and overall scores calculated! Proceed to the first round.');
            } else {
                return redirect()->route('view_minor_award', [
                    'eventId' => $eventId
                ])->with('success', 'Minor award rated successfully! Proceed to the next minor award.');
            }
        }

        if ($roundId) {
            foreach ($rates as $contestantRates) {
                $contestantId = $contestantRates['contestant_id'];

                foreach ($contestantRates['criteria'] as $criteriaId => $criteriaData) {
                    $rate = $criteriaData['rate'];

                    $criteria = Criteria::find($criteriaId);
                    if (!$criteria) {
                        return redirect()->back()->withErrors(['Criteria not found.'])->with('error', 'Criteria not found.');
                    }

                    if ($rate < $criteria->lowest_rate || $rate > $criteria->highest_rate) {
                        return redirect()->back()->withErrors(['Rate must be within criteria limits.'])->with('error', 'Rate must be within criteria limits.');
                    }

                    Score::updateOrCreate(
                        [
                            'contestant_id' => $contestantId,
                            'user_id' => $userId,
                            'round_id' => $roundId,
                            'criteria_id' => $criteriaId,
                            'event_id' => $eventId,
                        ],
                        ['rate' => $rate]
                    );
                }
            }

            RoundJudgeStatus::updateOrCreate(
                ['round_id' => $roundId, 'user_id' => $userId],
                ['completed' => true]
            );

            $allJudgesCompleted = RoundJudgeStatus::where('round_id', $roundId)
                ->where('completed', false)
                ->doesntExist();

            if ($allJudgesCompleted) {
                $round = Round::find($roundId);
                $round->completed = true;
                $round->save();

                $topContestants = $this->scoreService->determineTopContestants($roundId);

                $nextRound = Round::where('event_id', $eventId)
                    ->where('round_number', '>', $round->round_number)
                    ->first();

                if ($nextRound) {
                    $nextRound->contestants()->sync($topContestants);

                    return redirect()->route('voting_success', [
                        'eventId' => $eventId,
                        'roundId' => $nextRound->id,
                    ])->with('success', 'Proceed to the next round.');
                } else {
                    return redirect()->route('done_vote', ['eventId' => $eventId])
                        ->with('success', 'All rounds completed!');
                }
            }
        }

        return redirect()->route('voting_success', ['eventId' => $eventId])
            ->with('success', 'Scores submitted successfully!');
    }

    public function show_contestants_to_events($eventId)
    {
        $event = Event::with('contestants')->findOrFail($eventId);
        $rounds = Round::with('criteria')->where('event_id', $eventId)->get();
    
        // Get the first incomplete minor award, or null if all are rated
        $nextMinorAward = MinorAward::where('event_id', $eventId)
            ->whereDoesntHave('scores', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->first();
    
        // Check if all minor awards are rated or if there are no minor awards
        $minorAwardsComplete = !$nextMinorAward;
    
        // Get the first incomplete round, or null if all are complete
        $currentRound = $rounds->where('completed', false)->first();
    
        if ($minorAwardsComplete && $currentRound && $currentRound->round_number == 1) {
            // If minor awards are complete and it's the first round:
            // Get top contestants from minor awards
            $topContestantIds = RoundResult::where('round_id', $currentRound->id)
                ->where('qualified', true)
                ->pluck('contestant_id')
                ->toArray();
    
            // If top contestants from minor awards are available, use them for the first round
            if (!empty($topContestantIds)) {
                $contestants = Contestant::whereIn('id', $topContestantIds)->get();
            } else {
                // Fallback: Show all contestants if no minor awards or no top contestants
                $contestants = $event->contestants;
            }
        } elseif (!$nextMinorAward && $currentRound) {
            // If there are no minor awards, proceed with round logic
            if ($currentRound->round_number == 1) {
                $contestants = $event->contestants; // Show all contestants in the first round
            } else {
                // Show only the contestants qualified from the previous round
                $previousRound = $rounds->where('round_number', $currentRound->round_number - 1)->first();
                if ($previousRound) {
                    $topContestantIds = RoundResult::where('round_id', $previousRound->id)
                        ->where('qualified', true)
                        ->pluck('contestant_id')
                        ->toArray();
    
                    $contestants = Contestant::whereIn('id', $topContestantIds)->get();
                } else {
                    $contestants = $event->contestants; // Fallback to all contestants
                }
            }
        } else {
            // When minor awards are active, show all contestants
            $contestants = $event->contestants;
        }
    
        if ($currentRound) {
            $currentRound->load('criteria');
        }
    
        return view('judge_dashboard.Rate', [
            'event' => $event,
            'rounds' => $rounds,
            'contestants' => $contestants,
            'currentRound' => $currentRound,
            'nextMinorAward' => $nextMinorAward,
        ]);
    }
    
    


    public function showMinorAward($eventId)
    {
        $event = Event::with('contestants')->findOrFail($eventId);

        $nextMinorAward = MinorAward::where('event_id', $eventId)
            ->whereDoesntHave('scores', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->first();

        if (!$nextMinorAward) {
            return redirect()->route('voting_success', ['eventId' => $eventId])
                ->with('success', 'All minor awards rated!');
        }

        $contestants = $event->contestants;

        return view('judge_dashboard.Rate', [
            'event' => $event,
            'contestants' => $contestants,
            'nextMinorAward' => $nextMinorAward,
            'currentRound' => null,
        ]);
    }

    public function votingSuccess($eventId)
    {
        $event = Event::find($eventId);

        if (!$event) {
            return redirect()->route('error')->with('message', 'Event not found.');
        }

        $currentRound = $event->rounds()->where('completed', true)->latest()->first();
        $nextRound = $currentRound ? $event->rounds()->where('id', '>', $currentRound->id)->first() : $event->rounds()->first();

        if ($nextRound) {
            return view('judge_dashboard.success', [
                'event' => $event,
                'nextRound' => $nextRound,
            ]);
        } else {
            return redirect()->route('done_vote', ['eventId' => $event->id]);
        }
    }

    public function doneVote($eventId)
    {
        $event = Event::find($eventId);

        if (!$event) {
            return redirect()->route('error')->with('message', 'Event not found.');
        }

        return view('judge_dashboard.done_vote', ['event' => $event]);
    }

    public function nextRound($eventId)
    {
        $event = Event::findOrFail($eventId);
    
        $currentRound = $event->rounds()->where('completed', false)->first();
    
        if (!$currentRound) {
            return redirect()->route('done_vote', ['eventId' => $eventId])
                ->with('success', 'All rounds completed!');
        }
    
        return redirect()->route('view_contestants.event', [
            'eventId' => $eventId,
            'roundId' => $currentRound->id
        ])->with('success', 'Proceed to the next round.');
    }
}
