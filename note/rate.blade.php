@extends('layouts.judgeRate')

@section('content')
    <nav class="border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
        <form id="rateForm" action="{{ route('submit_rates') }}" method="POST">
            @csrf
            <input name="event_id" type="hidden" value="{{ $event->id }}">
            <input name="user_id" type="hidden" value="{{ auth()->id() }}">

            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-12">
                <!-- Minor Awards Selection -->
                @if ($minorAwards->isNotEmpty())
                    <div class="w-full sm:w-auto mb-4 sm:mb-0">
                        <label class="block text-sm font-medium text-gray-800" for="minor_award_id">Minor Award:</label>
                        <select class="select select-primary select-sm w-full max-w-xs" id="minor_award_id"
                            name="minor_award_id">
                            @foreach ($minorAwards as $award)
                                <option value="{{ $award->id }}">{{ $award->minor_awards_description }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Round Selection -->
                <div class="w-full sm:w-auto mb-4 sm:mb-0">
                    <label class="block text-sm font-medium text-gray-800" for="round_id">Round Description:</label>
                    <select class="select select-primary select-sm w-full max-w-xs" id="round_id" name="round_id">
                        @foreach ($rounds as $round)
                            @if (!$round->completed)
                                <option value="{{ $round->id }}" {{ $round->id == $currentRound->id ? 'selected' : '' }}>
                                    {{ $round->round_description }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col text-center w-full">
                    <h2 class="text-xs text-red-500 tracking-widest font-medium title-font mb-1">RATE INFORMATION</h2>
                    <h2 class="sm:text-3xl text-2xl font-medium title-font text-green-900">
                        {{ $currentRound->round_description }}
                    </h2>
                </div>
            </div>
    </nav>

    <section class="text-gray-600 body-font p-2">
        <div class="container px-5 py-12 mx-auto">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" id="contestants-container">
                @foreach ($contestants as $contestant)
                    <div
                        class="bg-white border border-gray-300 rounded-lg shadow-xl hover:shadow-lg transition-shadow duration-200 m-4 card-bg contestant-card">
                        <div class="flex flex-col items-center p-2">
                            <div class="flex items-center justify-center">
                                <h2 class="text-gray-900 title-font text-lg font-semibold uppercase">
                                    #{{ $contestant->number }}</h2>
                                <p class="text-sm text-gray-900 ml-2">{{ $contestant->name }}</p>
                            </div>
                            <div class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 overflow-hidden my-4">
                                <img class="w-full h-full object-cover" src="{{ asset($contestant->profile) }}"
                                    alt="{{ $contestant->name }} Image">
                            </div>
                            <input name="rates[{{ $contestant->id }}][contestant_id]" type="hidden"
                                value="{{ $contestant->id }}">
                            <div class="criteria-container">
                                @foreach ($currentRound->criteria as $criteria)
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-900">
                                            Rate for {{ $criteria->criteria_description }}:
                                        </label>
                                        <input
                                            class="rate-input mt-1 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm placeholder-gray-400 dark:bg-gray-700 dark:text-gray-200"
                                            name="rates[{{ $contestant->id }}][criteria][{{ $criteria->id }}][rate]"
                                            type="number" step="0.01" min="{{ $criteria->lowest_rate }}"
                                            max="{{ $criteria->highest_rate }}" required="required"
                                            placeholder=" lowest:{{ $criteria->lowest_rate }} | higest: {{ $criteria->highest_rate }} ">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-center mt-16">
                <button class="button type1" type="submit">Submit</button>
            </div>
        </div>
    </section>
    </form>
@endsection






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
            'round_id' => 'required|exists:rounds,id',
            'rates.*.contestant_id' => 'required|exists:contestants,id',
            'rates.*.criteria.*.rate' => 'required|numeric|min:0',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', 'Validation error.');
        }
    
        $eventId = $request->input('event_id');
        $userId = $request->input('user_id');
        $roundId = $request->input('round_id');
        $rates = $request->input('rates');
    
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
    
                // Save or update the score for the specific judge
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
    
        // Mark the judge's round as completed
        RoundJudgeStatus::updateOrCreate(
            ['round_id' => $roundId, 'user_id' => $userId],
            ['completed' => true]
        );
    
        // Check if all judges have completed voting for this round
        $allJudgesCompleted = RoundJudgeStatus::where('round_id', $roundId)
            ->where('completed', false)
            ->doesntExist();
    
        if ($allJudgesCompleted) {
            // Mark the round as completed
            $round = Round::find($roundId);
            $round->completed = true;
            $round->save();
    
            // Determine top contestants for the next round based on all judges' scores
            $topContestants = $this->scoreService->determineTopContestants($roundId);
    
            // Check if there's a next round
            $nextRound = Round::where('event_id', $eventId)
                ->where('round_number', '>', $round->round_number)
                ->first();
    
            if ($nextRound) {
                // Sync top contestants to the next round
                $nextRound->contestants()->sync($topContestants);
    
                // Redirect to the "Voting Success" page
                return redirect()->route('voting_success', [
                    'eventId' => $eventId,
                    'roundId' => $nextRound->id
                ]);
            } else {
                // No more rounds, finalize the event
                return redirect()->route('done_vote', ['eventId' => $eventId])
                    ->with('success', 'All rounds completed!');
            }
        }
    
        return redirect()->route('voting_success', ['eventId' => $eventId])
            ->with('success', 'Scores submitted successfully!');
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

public function showMinorAward($eventId){
    return view('')
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
    
        // Find the next round
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
    
    

    public function show_contestants_to_events($eventId)
    {
        $event = Event::with('contestants')->findOrFail($eventId);
        $rounds = Round::with('criteria')->where('event_id', $eventId)->get();
        $minorAwards = MinorAward::where('event_id', $eventId)->get();
        
        // Get the first incomplete round, or null if all are complete
        $currentRound = $rounds->where('completed', false)->first(); 
    
        if (!$currentRound) {
            $contestants = $event->contestants;
        } else {
            $previousRound = $rounds->where('round_number', $currentRound->round_number - 1)->first();
            if ($previousRound) {
                $topContestantIds = RoundResult::where('round_id', $previousRound->id)
                    ->orderBy('total_score', 'desc')
                    ->take($previousRound->top_contestants)
                    ->pluck('contestant_id')
                    ->toArray();
    
                $contestants = empty($topContestantIds) ? $event->contestants : Contestant::whereIn('id', $topContestantIds)->get();
            } else {
                $contestants = $event->contestants;
            }
        }
    
        if ($currentRound) {
            $currentRound->load('criteria');
        }
    
        return view('judge_dashboard.Rate', [
            'event' => $event,
            'rounds' => $rounds,
            'contestants' => $contestants,
            'currentRound' => $currentRound,
            'minorAwards' => $minorAwards, // Pass minor awards to the view
        ]);
    }
    
    
    

    public function showFinalScores($eventId)
    {
        $userId = auth()->id();
        $event = Event::findOrFail($eventId);
        $rounds = $event->rounds()->with('criteria')->get();
        $scores = Score::where('user_id', $userId)
            ->whereIn('round_id', $rounds->pluck('id'))
            ->get();

        $finalScores = [];
        foreach ($scores as $score) {
            if (!isset($finalScores[$score->contestant_id])) {
                $finalScores[$score->contestant_id] = [
                    'contestant_id' => $score->contestant_id,
                    'name' => $score->contestant->name,
                    'number' => $score->contestant->number,
                    'round_scores' => [],
                    'final_score' => 0,
                ];
            }
            $finalScores[$score->contestant_id]['round_scores'][$score->round_id][$score->criteria_id] = $score->rate;
            $finalScores[$score->contestant_id]['final_score'] += $score->rate;
        }

        $finalScores = collect($finalScores);

        return view('judge_dashboard.Score_result', compact('finalScores', 'event', 'rounds', 'eventId'));
    }
}
