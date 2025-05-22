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
use App\Models\JudgeApproval;
use App\Models\EventJudge;
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

            // Mark this judge's status as completed for this round
        RoundJudgeStatus::updateOrCreate(
            ['round_id' => $roundId, 'user_id' => $userId],
            ['completed' => true]
        );

        $round = Round::with('event')->find($roundId);
        
        // Get count of all judges assigned to this event
        $assignedJudges = EventJudge::where('event_id', $round->event_id)->pluck('judge_id');
        $assignedJudgeCount = $assignedJudges->count();
        
        // Get count of judges who have completed this round
        $completedJudgeCount = RoundJudgeStatus::where('round_id', $roundId)
            ->whereIn('user_id', $assignedJudges)
            ->where('completed', true)
            ->count();

        // If all assigned judges have submitted their scores
        if ($completedJudgeCount >= $assignedJudgeCount) {
            // Mark the round as completed
            Round::where('id', $roundId)->update(['completed' => true]);
            
            // Calculate top contestants and set up next round
            $topContestants = $this->scoreService->determineTopContestants($roundId);
            
            $nextRound = Round::where('event_id', $round->event_id)
                ->where('round_number', '>', $round->round_number)
                ->first();

            if ($nextRound) {
                $nextRound->contestants()->sync($topContestants);
            }
        }

        // Check if current judge has any remaining rounds
        $hasUnvotedRounds = Round::where('event_id', $round->event_id)
            ->whereDoesntHave('judgeStatuses', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->where('completed', true);
            })
            ->exists();

        if (!$hasUnvotedRounds) {
            return redirect()->route('done_vote', ['eventId' => $round->event_id])
                ->with('success', 'You have completed all rounds!');
        }

        return redirect()->route('voting_success', [
            'eventId' => $round->event_id
        ])->with('success', 'Scores submitted successfully!');
    }
    }


    public function show_contestants_to_events($eventId)
    {
        $event = Event::with('contestants')->findOrFail($eventId);
        $rounds = Round::with('criteria')->where('event_id', $eventId)->get();

        // Check if minor awards exist for the event
        $minorAwardsExist = MinorAward::where('event_id', $eventId)->exists();

        // If minor awards exist, get the first incomplete minor award
        $nextMinorAward = $minorAwardsExist ? MinorAward::where('event_id', $eventId)
            ->whereDoesntHave('scores', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->first() : null;

        // Determine if all minor awards are completed
        $minorAwardsComplete = !$minorAwardsExist || !$nextMinorAward;


        $currentRound = $rounds->where('completed', false)->first();

        if ($currentRound) {
            $contestants = $currentRound->contestants()->get();
            if ($contestants->isEmpty()) {
                $contestants = $event->contestants;
            }
        } else {
            $contestants = $event->contestants;
        }

        // If contestants are still not found, check if they should come from a previous round
        if ($contestants->isEmpty() && $minorAwardsComplete) {
            $previousRound = $rounds->where('round_number', $currentRound->round_number - 1)->first();
            if ($previousRound) {
                $topContestantIds = RoundResult::where('round_id', $previousRound->id)
                    ->orderBy('total_score', 'desc')
                    ->take($previousRound->top_contestants)
                    ->pluck('contestant_id')
                    ->toArray();

                $contestants = Contestant::whereIn('id', $topContestantIds)->get();
            }
        }
        $contestants = $contestants->sortBy('number');
        // Load criteria for the current round
        if ($currentRound) {
            $currentRound->load('criteria');
        }

        // Fetch judge approvals for the current event
        $judgeApprovals = JudgeApproval::where('judge_id', auth()->id())
            ->where('event_id', $eventId)
            ->with(['event', 'contestant'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('judge_dashboard.Rate', [
            'event' => $event,
            'rounds' => $rounds,
            'contestants' => $contestants,
            'currentRound' => $currentRound,
            'nextMinorAward' => $nextMinorAward,
            'judgeApprovals' => $judgeApprovals, 
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
    
        // Check if current judge has any unvoted rounds
        $hasUnvotedRounds = Round::where('event_id', $eventId)
            ->whereDoesntHave('judgeStatuses', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('completed', true);
            })
            ->exists();
    
        if (!$hasUnvotedRounds) {
            return redirect()->route('done_vote', ['eventId' => $event->id]);
        }
    
        $nextRound = Round::where('event_id', $eventId)
            ->whereDoesntHave('judgeStatuses', function ($query) {
                $query->where('user_id', auth()->id())
                    ->where('completed', true);
            })
            ->first();
    
        return view('judge_dashboard.success', [
            'event' => $event,
            'nextRound' => $nextRound,
        ]);
    }

    public function isCompletelyJudged()
{
    $assignedJudges = EventJudge::where('event_id', $this->event_id)->pluck('judge_id');
    $completedJudges = RoundJudgeStatus::where('round_id', $this->id)
        ->whereIn('user_id', $assignedJudges)
        ->where('completed', true)
        ->count();
        
    return $completedJudges >= $assignedJudges->count();
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
