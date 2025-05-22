<?php

namespace App\Http\Controllers;

use App\Models\JudgeApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Add for logging
use  App\Models\MinorAward;
use App\Models\MinorAwardScore;
use App\Models\overall_Minoraward_scores;
use App\Models\MinorAwardSetting;
use App\Models\EventJudge;
use Illuminate\Support\Facades\DB;
use App\Models\Users_vote;
use App\Models\Score;
use App\Models\Event;
use App\Models\User;
use App\Models\Round;
use App\Models\Contestant;
class JudgeApprovalController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Incoming Approval Request', $request->all());

        try {
            $validatedData = $request->validate([
                'judge_id' => 'required|exists:users,id',
                'event_id' => 'required|exists:events,id',
                'approval_type' => 'required|in:minor_awards,overall_scores,round_scores',
                'minor_awards' => 'required_if:approval_type,minor_awards|array',
                'minor_awards.*' => 'array',
                'minor_awards.*.*' => 'sometimes|nullable|in:1',
                'minor_award_id' => 'required_if:approval_type,minor_awards|exists:minor_awards,id',
                'overall_scores' => 'required_if:approval_type,overall_scores|array',
                'round_scores' => 'required_if:approval_type,round_scores|array',
                'round_id' => 'required_if:approval_type,round_scores|exists:rounds,id',
            ]);

            Log::info('Validated Data', $validatedData);

            $approvals = [];
    
            switch ($validatedData['approval_type']) {
                case 'minor_awards':
                    Log::info('Processing Minor Awards');
                    foreach ($validatedData['minor_awards'] as $minorAwardId => $contestantIds) {
                        Log::info('Processing Minor Award', ['award_id' => $minorAwardId]);
                        $minorAward = MinorAward::findOrFail($minorAwardId);
                        Log::info('Contestant IDs from form', ['contestant_ids' => $contestantIds]);
                        $validContestantIds = Contestant::where('event_id', $validatedData['event_id'])
                            ->whereIn('id', $contestantIds)
                            ->pluck('id')
                            ->toArray();
                        Log::info('Valid Contestant IDs', ['valid_ids' => $validContestantIds]);
                        foreach ($validContestantIds as $contestantId) {
                            $approvals[] = [
                                'judge_id' => $validatedData['judge_id'],
                                'event_id' => $validatedData['event_id'],
                                'contestant_id' => $contestantId,
                                'approval_type' => 'minor_awards',
                                'award_id' => $minorAwardId,
                            ];
                        }
                    }
                    Log::info('Approvals after processing minor awards', ['approvals' => $approvals]);
                    break;

                case 'overall_scores':
                    $contestantIds = $validatedData['overall_scores'] ?? [];
                    Log::info('Overall Scores Contestant IDs', ['contestant_ids' => $contestantIds]);
                    $validContestantIds = Contestant::where('event_id', $validatedData['event_id'])
                        ->whereIn('id', $contestantIds)
                        ->pluck('id')
                        ->toArray();
                    Log::info('Valid Overall Scores Contestant IDs', ['valid_ids' => $validContestantIds]);
                    foreach ($validContestantIds as $contestantId) {
                        $approvals[] = [
                            'judge_id' => $validatedData['judge_id'],
                            'event_id' => $validatedData['event_id'],
                            'contestant_id' => $contestantId,
                            'approval_type' => 'overall_scores',
                            'award_id' => null,
                        ];
                    }
                    break;

                case 'round_scores':
                    $roundId = $validatedData['round_id'];
                    Log::info('Processing Round Scores', ['round_id' => $roundId]);
                    $contestantIds = $validatedData['round_scores'] ?? [];
                    Log::info('Round Scores Contestant IDs', ['contestant_ids' => $contestantIds]);
                    $validContestantIds = Contestant::where('event_id', $validatedData['event_id'])
                        ->whereIn('id', $contestantIds)
                        ->pluck('id')
                        ->toArray();
                    Log::info('Valid Round Scores Contestant IDs', ['valid_ids' => $validContestantIds]);
                    foreach ($validContestantIds as $contestantId) {
                        $approvals[] = [
                            'judge_id' => $validatedData['judge_id'],
                            'event_id' => $validatedData['event_id'],
                            'contestant_id' => $contestantId,
                            'approval_type' => 'round_scores',
                            'award_id' => $roundId,
                        ];
                    }
                    break;

                default:
                    throw new \InvalidArgumentException('Invalid approval type');
            }

            Log::info('Prepared approvals for insertion', ['approvals' => $approvals]);

            if (empty($approvals)) {
                DB::rollBack();
                Log::warning('No valid approvals to insert');
                return redirect()->back()->with('error', 'No valid approvals to store. Please select at least one contestant.');
            }

            $insertedApprovals = [];
            foreach ($approvals as $approval) {
                try {
                    $inserted = JudgeApproval::create($approval);
                    $insertedApprovals[] = $inserted;
                    Log::info('Inserted approval', ['approval' => $inserted]);
                } catch (\Exception $e) {
                    Log::error('Failed to insert approval', ['approval' => $approval, 'error' => $e->getMessage()]);
                    throw $e;
                }
            }

            DB::commit();

            if (empty($insertedApprovals)) {
                Log::error('Failed to insert any approvals');
                return redirect()->back()->with('error', 'Failed to store any approvals. Please check the logs for more information.');
            }

            return redirect()->back()->with('success', 'Approvals stored successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store approvals', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to store approvals: ' . $e->getMessage());
        }
    }




    public function approval($eventId)
    {
        $event = Event::findOrFail($eventId);
        $judgeIds = EventJudge::where('event_id', $eventId)->pluck('judge_id');
        $judges = User::whereIn('id', $judgeIds)->get();
        $contestants = Contestant::where('event_id', $eventId)->get()->keyBy('id');
        
        $overallMinorAwardScores = overall_Minoraward_scores::where('event_id', $eventId)
            ->with('contestant')
            ->get()
            ->groupBy('contestant_id')
            ->map(function ($scores) use ($contestants) {
                $contestantId = $scores->first()->contestant_id;
                $contestant = $contestants->get($contestantId);
                return [
                    'totalScore' => $scores->sum('overall_score'),
                    'scores' => $scores,
                    'id' => $scores->first()->id,
                    'contestant' => $contestant ? $contestant->name : 'Unknown Contestant',
                ];
            })
            ->sortByDesc(function ($data) {
                return $data['totalScore'];
            });
        
        $minorAwards = MinorAward::where('event_id', $eventId)->get();
        
        $minorAwardScores = MinorAwardScore::where('event_id', $eventId)
            ->with(['contestant', 'user', 'minorAward'])
            ->get()
            ->groupBy(['minor_award_id', 'contestant_id']);
        
        $maleMinorAwardScores = [];
        $femaleMinorAwardScores = [];
        foreach ($minorAwardScores as $minorAwardId => $scores) {
            $maleMinorAwardScores[$minorAwardId] = [];
            $femaleMinorAwardScores[$minorAwardId] = [];
            foreach ($scores as $contestantId => $contestantScores) {
                $contestant = $contestants->get($contestantId);
                if ($contestant) {
                    $scoreData = [
                        'contestant' => $contestant,
                        'scores' => $contestantScores,
                        'total' => $contestantScores->sum('rate')
                    ];
                    if ($contestant->category === 'male') {
                        $maleMinorAwardScores[$minorAwardId][$contestantId] = $scoreData;
                    } else {
                        $femaleMinorAwardScores[$minorAwardId][$contestantId] = $scoreData;
                    }
                } else {
                    Log::warning("Contestant not found for ID: {$contestantId} in minor award {$minorAwardId}");
                }
            }
            arsort($maleMinorAwardScores[$minorAwardId]);
            arsort($femaleMinorAwardScores[$minorAwardId]);
        }
        
        $rounds = Round::where('event_id', $eventId)->with('criteria')->get();
        
        $combinedJudgesScores = $this->getCombinedJudgesScores($eventId);
        
        foreach ($combinedJudgesScores as $roundId => $roundScores) {
            foreach ($roundScores as $contestantId => $scoreData) {
                $contestant = $contestants->get($contestantId);
                $combinedJudgesScores[$roundId][$contestantId]['contestant_name'] = $contestant ? $contestant->name : 'Unknown Contestant';
            }
        }
    
        return view('admin_dashboard.Results.tie_approval', compact(
            'event',
            'judges',
            'contestants',
            'overallMinorAwardScores',
            'minorAwards',
            'maleMinorAwardScores',
            'femaleMinorAwardScores',
            'rounds',
            'combinedJudgesScores'
        ));
    }

    private function getCombinedJudgesScores($eventId)
    {
        $rounds = Round::where('event_id', $eventId)->with('criteria')->get();
        $combinedScores = [];

        foreach ($rounds as $round) {
            $roundScores = Score::where('round_id', $round->id)
                ->with(['contestant', 'user', 'criteria'])
                ->get()
                ->groupBy(['contestant_id', 'criteria_id']);

            $combinedScores[$round->id] = [];

            foreach ($roundScores as $contestantId => $criteriaScores) {
                $contestantTotalScore = 0;

                foreach ($criteriaScores as $criteriaId => $judgeScores) {
                    $criteriaAverage = $judgeScores->avg('rate');
                    $contestantTotalScore += $criteriaAverage;

                    $combinedScores[$round->id][$contestantId]['criteria'][$criteriaId] = $criteriaAverage;
                }

                $combinedScores[$round->id][$contestantId]['total'] = $contestantTotalScore;
            }

            // Sort contestants by total score for each round
            arsort($combinedScores[$round->id]);
        }

        return $combinedScores;
    }
    

  
}
