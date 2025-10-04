<?php

namespace App\Http\Controllers;

use App\Models\EventJudge;
use Illuminate\Http\Request;
use App\Models\Users_vote;
use App\Models\Score;
use App\Models\Event;
use App\Models\User;
use App\Models\Round;
use App\Models\Contestant;
use Barryvdh\DomPDF\Facade\Pdf;
use  App\Models\MinorAward;
use App\Models\MinorAwardScore;
use App\Models\overall_Minoraward_scores;
use App\Models\MinorAwardSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ShowScore_in_admin extends Controller
{
    // Results event select
    public function showResults(Request $request)
    {
        $query = Event::where('user_id', Auth::id())->where('event_status', 'started');

        $events = $query->paginate(10);
        return view('admin_dashboard.ScoreResults', ['events' => $events]);
    }

    public function showJudgeScores($eventId)
    {
        $event = Event::findOrFail($eventId);
        $rounds = Round::where('event_id', $eventId)->with('criteria')->get();

        // Get main scores
        $scores = Score::whereHas('contestant', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })
            ->with(['contestant', 'round', 'criteria', 'user'])
            ->get()
            ->groupBy(['round_id', 'contestant_id']);

        // Get minor award scores
        $minorAwardScores = MinorAwardScore::where('event_id', $eventId)
            ->with(['contestant', 'user', 'minorAward'])
            ->get()
            ->groupBy(['minor_award_id', 'user_id', 'contestant_id']);


        // Get all judges
        $allJudges = User::whereHas('events', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })->get();

        $minorAwards = MinorAward::where('event_id', $eventId)->get();

        // Map of hidden criteria per judge: [judge_id => [criteria_id, ...]]
        $hiddenCriteriaByJudge = DB::table('criteria_hidden_judges')
            ->select('judge_id', 'criteria_id')
            ->get()
            ->groupBy('judge_id')
            ->map(function ($rows) {
                return $rows->pluck('criteria_id')->toArray();
            })
            ->toArray();

        return view('admin_dashboard.Results.judge_score', compact('event', 'rounds', 'scores', 'allJudges', 'minorAwardScores', 'minorAwards', 'hiddenCriteriaByJudge'));
    }


    public function showUserVotes($eventId)
    {
        $event = Event::with('minorAwards')->findOrFail($eventId);

        $contestants = Contestant::where('event_id', $eventId)
            ->withCount(['votes' => function ($query) {
                $query->select(DB::raw('SUM(vote_count)'));
            }])
            ->orderByDesc('votes_count')
            ->get();

        $totalVotes = $contestants->sum('votes_count');

        $userVotes = $contestants->mapWithKeys(function ($contestant) {
            return [$contestant->id => $contestant->votes_count];
        });

        return view('admin_dashboard.Results.user_vote', compact('event', 'contestants', 'userVotes', 'totalVotes'));
    }


    public function printScores(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        // Get contestants with their scores
        $contestants = Contestant::where('event_id', $eventId)
            ->withCount(['votes' => function ($query) {
                $query->select(DB::raw('SUM(vote_count)'));
            }])
            ->with(['minorAwardScores' => function ($query) {
                $query->with('minorAward');
            }])
            ->get();

        // Calculate scores based on weights
        $scores = $contestants->map(function ($contestant) use ($request) {
            $totalScore = $this->calculateContestantScore(
                $contestant,
                $request->userVoteWeight,
                $request->minorAwardsWeight,
                $request->scoringType,
                $request->minorAwards ?? null
            );

            return [
                'name' => $contestant->name,
                'number' => $contestant->number,
                'total_score' => number_format($totalScore, 2)
            ];
        })->sortByDesc('total_score')->values();

        return view('admin_dashboard.Results.print_users_vote', [
            'eventTitle' => $event->event_name,
            'scores' => $scores,
            'scoringType' => $request->scoringType,
            'userVoteWeight' => $request->userVoteWeight,
            'minorAwardsWeight' => $request->minorAwardsWeight
        ]);
    }

    private function calculateContestantScore($contestant, $userVoteWeight, $minorAwardsWeight, $scoringType, $minorAwards = null)
    {
        // Calculate vote percentage
        $totalVotes = Contestant::where('event_id', $contestant->event_id)
            ->withCount(['votes' => function ($query) {
                $query->select(DB::raw('SUM(vote_count)'));
            }])
            ->get()
            ->sum('votes_count');

        $votePercentage = $totalVotes > 0 ?
            ($contestant->votes_count / $totalVotes) * 100 : 0;

        // Calculate minor awards score based on scoring type
        $minorAwardsScore = 0;

        if ($scoringType === 'userVote') {
            return $votePercentage; // Return only vote percentage
        } elseif (str_starts_with($scoringType, 'minorAward_')) {
            $awardId = substr($scoringType, 11);
            $awardScores = $contestant->minorAwardScores
                ->where('minor_award_id', $awardId);

            if ($awardScores->isNotEmpty()) {
                return $awardScores->avg('rate');
            }
            return 0;
        } elseif ($scoringType === 'combined_all' && $minorAwards) {
            $totalAwards = count($minorAwards);
            $awardWeight = 100 / $totalAwards;

            foreach ($minorAwards as $award) {
                $awardScores = $contestant->minorAwardScores
                    ->where('minor_award_id', $award['id']);

                if ($awardScores->isNotEmpty()) {
                    $averageScore = $awardScores->avg('rate');
                    $weightedScore = ($averageScore * $awardWeight) / 100;
                    $minorAwardsScore += $weightedScore;
                }
            }
        } elseif (str_starts_with($scoringType, 'combined_')) {
            $awardId = substr($scoringType, 9);
            $awardScores = $contestant->minorAwardScores
                ->where('minor_award_id', $awardId);

            if ($awardScores->isNotEmpty()) {
                $minorAwardsScore = $awardScores->avg('rate');
            }
        }

        // Calculate weighted scores
        $weightedVoteScore = ($votePercentage * $userVoteWeight) / 100;
        $weightedMinorScore = ($minorAwardsScore * $minorAwardsWeight) / 100;

        return $weightedVoteScore + $weightedMinorScore;
    }


    public function calculateCombinedScores(Request $request, $eventId)
    {
        try {
            $event = Event::findOrFail($eventId);

            // Get contestants with votes and minor award scores
            $contestants = Contestant::where('event_id', $eventId)
                ->withCount(['votes' => function ($query) {
                    $query->select(DB::raw('SUM(vote_count)'));
                }])
                ->with(['minorAwardScores' => function ($query) {
                    $query->with('minorAward');
                }])
                ->get();

            $totalVotes = $contestants->sum('votes_count');
            $scores = [];

            foreach ($contestants as $contestant) {
                // Calculate vote percentage
                $votePercentage = $totalVotes > 0 ? ($contestant->votes_count / $totalVotes) * 100 : 0;

                // Calculate minor awards score based on selected scoring type
                $minorAwardsScore = 0;
                $minorAwardsData = [];

                if ($request->scoringType === 'userVote') {
                    // Use only user votes
                    $minorAwardsScore = 0;
                } elseif (str_starts_with($request->scoringType, 'minorAward_')) {
                    // Calculate single minor award score
                    $awardId = substr($request->scoringType, 11);
                    $awardScores = $contestant->minorAwardScores
                        ->where('minor_award_id', $awardId);

                    if ($awardScores->isNotEmpty()) {
                        $averageScore = $awardScores->avg('rate');
                        $minorAwardsScore = $averageScore;
                        $minorAwardsData[$awardId] = $averageScore;
                    }
                } elseif ($request->scoringType === 'combined_all') {
                    // Calculate all minor awards with equal weights
                    $totalAwards = count($request->minorAwards);
                    $awardWeight = 100 / $totalAwards;

                    foreach ($request->minorAwards as $award) {
                        $awardScores = $contestant->minorAwardScores
                            ->where('minor_award_id', $award['id']);

                        if ($awardScores->isNotEmpty()) {
                            $averageScore = $awardScores->avg('rate');
                            $weightedScore = ($averageScore * $awardWeight) / 100;
                            $minorAwardsScore += $weightedScore;
                            $minorAwardsData[$award['id']] = $averageScore;
                        }
                    }
                } elseif (str_starts_with($request->scoringType, 'combined_')) {
                    // Combine user votes with specific minor award
                    $awardId = substr($request->scoringType, 9);
                    $awardScores = $contestant->minorAwardScores
                        ->where('minor_award_id', $awardId);

                    if ($awardScores->isNotEmpty()) {
                        $averageScore = $awardScores->avg('rate');
                        $minorAwardsScore = $averageScore;
                        $minorAwardsData[$awardId] = $averageScore;
                    }
                }

                // Calculate total score based on weights
                $weightedVoteScore = ($votePercentage * $request->userVoteWeight) / 100;
                $weightedMinorScore = ($minorAwardsScore * $request->minorAwardsWeight) / 100;
                $totalScore = $weightedVoteScore + $weightedMinorScore;

                $scores[] = [
                    'contestant' => [
                        'id' => $contestant->id,
                        'name' => $contestant->name,
                        'number' => $contestant->number,
                        'profile' => asset($contestant->profile)
                    ],
                    'vote_percentage' => $votePercentage,
                    'vote_count' => $contestant->votes_count,
                    'minor_awards_score' => $minorAwardsScore,
                    'minor_awards' => $minorAwardsData,
                    'weighted_vote_score' => $weightedVoteScore,
                    'weighted_minor_score' => $weightedMinorScore,
                    'total_score' => $totalScore
                ];
            }

            // Sort by total score descending
            usort($scores, function ($a, $b) {
                return $b['total_score'] <=> $a['total_score'];
            });

            return response()->json([
                'success' => true,
                'scores' => $scores,
                'weights' => [
                    'userVote' => $request->userVoteWeight,
                    'minorAwards' => $request->minorAwardsWeight
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in calculateCombinedScores: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error calculating scores: ' . $e->getMessage()
            ], 500);
        }
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


    public function showOverallScores($eventId)
    {
        $event = Event::findOrFail($eventId);
        $rounds = Round::where('event_id', $eventId)->with('criteria')->get();
        $combinedJudgesScores = $this->getCombinedJudgesScores($eventId);

        // Fetch all scores for the event
        $scores = Score::whereHas('contestant', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })
            ->with(['contestant', 'round', 'criteria', 'user'])
            ->get()
            ->groupBy(['round_id', 'criteria_id', 'contestant_id']);

        // Fetch all contestants for the event
        $contestants = Contestant::where('event_id', $eventId)->get();

        // Fetch judges associated with the event
        $judges = User::whereHas('events', function ($query) use ($eventId) {
            $query->where('event_id', $eventId);
        })->get();

        // Minor award scores grouped by minor award and contestant
        $minorAwardScores = MinorAwardScore::where('event_id', $eventId)
            ->with(['contestant', 'user', 'minorAward'])
            ->get()
            ->groupBy(['minor_award_id', 'contestant_id']);

        // Separate minor award scores by gender
        $maleMinorAwardScores = [];
        $femaleMinorAwardScores = [];

        foreach ($minorAwardScores as $minorAwardId => $scores) {
            $maleMinorAwardScores[$minorAwardId] = [];
            $femaleMinorAwardScores[$minorAwardId] = [];

            foreach ($scores as $contestantId => $contestantScores) {
                $contestant = $contestants->find($contestantId);
                if ($contestant->category === 'male') {
                    $maleMinorAwardScores[$minorAwardId][$contestantId] = $contestantScores;
                } else {
                    $femaleMinorAwardScores[$minorAwardId][$contestantId] = $contestantScores;
                }
            }
        }

        // Fetch overall minor award scores including the ID and sort them
        $overallMinorAwardScores = overall_Minoraward_scores::where('event_id', $eventId)
            ->with('event')
            ->get()
            ->groupBy('contestant_id')
            ->map(function ($scores) {
                return [
                    'totalScore' => $scores->sum('overall_score'),
                    'scores' => $scores,
                    'id' => $scores->first()->id,
                ];
            })
            ->sortByDesc(function ($data) {
                return $data['totalScore'];
            });

        // Get the top contestant limit from the minor_awards_settings table
        $topContestantLimit = MinorAwardSetting::where('event_id', $eventId)->value('top_contestant_limit') ?? 5;

        // Limit the number of top contestants
        $topContestants = $overallMinorAwardScores->take($topContestantLimit);

        // Get minor awards assigned to the event
        $minorAwards = MinorAward::where('event_id', $eventId)->get();

        // Check if there are any minor awards assigned
        $hasMinorAwards = $minorAwards->isNotEmpty();

        // Calculate overall scores and criteria winners for each round
        $criteriaWinners = [];
        $totalScores = [];

        foreach ($rounds as $round) {
            $roundTotalScores = [];
            $roundCriteriaWinners = [];

            foreach ($round->criteria as $criteria) {
                $criteriaScores = $scores[$round->id][$criteria->id] ?? collect();
                $contestantData = [];

                foreach ($criteriaScores as $contestantId => $contestantScores) {
                    $totalScore = $contestantScores->sum('rate');
                    $contestantData[$contestantId] = $totalScore;
                }

                if (!empty($contestantData)) {
                    arsort($contestantData);
                    $winnerId = array_key_first($contestantData);
                    $roundCriteriaWinners[$criteria->id] = [
                        'contestant_id' => $winnerId,
                        'score' => $contestantData[$winnerId]
                    ];

                    foreach ($contestantData as $contestantId => $totalScore) {
                        $roundTotalScores[$contestantId] = ($roundTotalScores[$contestantId] ?? 0) + $totalScore;
                    }
                }
            }

            $criteriaWinners[$round->id] = $roundCriteriaWinners;
            $totalScores[$round->id] = $roundTotalScores;
        }

        // Calculate winners for each minor award by combining judges' scores
        $minorAwardCriteriaWinners = [];
        $sortedMinorAwardScores = [];

        if ($hasMinorAwards) {
            foreach ($minorAwardScores as $minorAwardId => $contestantScores) {
                $contestantData = [];

                foreach ($contestantScores as $contestantId => $scores) {
                    $totalScore = $scores->sum('rate');
                    $contestantData[$contestantId] = $totalScore;
                }

                if (!empty($contestantData)) {
                    arsort($contestantData);
                    $winnerId = array_key_first($contestantData);
                    $minorAwardCriteriaWinners[$minorAwardId] = [
                        'contestant_id' => $winnerId,
                        'score' => $contestantData[$winnerId]
                    ];
                    $sortedMinorAwardScores[$minorAwardId] = $contestantData;
                }
            }
        }

        // Contestants and User Votes
        $userVotes = Users_vote::where('event_id', $eventId)->get()->groupBy('contestant_id');
        $totalVotes = $userVotes->flatten()->count();
        $votePercentages = [];

        foreach ($contestants as $contestant) {
            $contestantVotes = $userVotes[$contestant->id] ?? collect();
            $votePercentage = ($totalVotes > 0) ? ($contestantVotes->count() / $totalVotes) * 100 : 0;
            $votePercentages[$contestant->id] = $votePercentage;
        }

        return view('admin_dashboard.Results.overall_score', compact(
            'event',
            'rounds',
            'scores',
            'totalScores',
            'criteriaWinners',
            'minorAwards',
            'maleMinorAwardScores',
            'femaleMinorAwardScores',
            'sortedMinorAwardScores',
            'minorAwardCriteriaWinners',
            'contestants',
            'votePercentages',
            'overallMinorAwardScores',
            'hasMinorAwards',
            'topContestants',
            'combinedJudgesScores',
            'judges' // Pass judges to the view
        ));
    }




    public function getCriteriaWinners($roundId)
    {
        $round = Round::with('criteria')->findOrFail($roundId);
        $scores = Score::where('round_id', $roundId)
            ->with(['contestant', 'criteria'])
            ->get()
            ->groupBy(['criteria_id', 'contestant_id']);

        $criteriaWinners = [];

        foreach ($round->criteria as $criteria) {
            $criteriaScores = $scores[$criteria->id] ?? collect();
            $contestantData = [];

            foreach ($criteriaScores as $contestantId => $contestantScores) {
                $totalScore = $contestantScores->sum('rate');
                $contestantData[$contestantId] = $totalScore;
            }

            if (!empty($contestantData)) {
                arsort($contestantData);
                $winnerId = array_key_first($contestantData);
                $criteriaWinners[$criteria->id] = ['contestant_id' => $winnerId, 'score' => $contestantData[$winnerId]];
            }
        }

        return $criteriaWinners;
    }

    public function print_pdf($roundId, $tableType, $criterionId = null)
    {
        // Retrieve the round along with its criteria
        $round = Round::with('criteria')->findOrFail($roundId);

        // Retrieve the criteria winners
        $criteriaWinners = $this->getCriteriaWinners($roundId);

        // Retrieve all contestants
        $contestants = Contestant::all();

        // Fetch all criteria scores for the round
        $scores = [];
        foreach ($round->criteria as $criteria) {
            $scores[$criteria->id] = Score::where('criteria_id', $criteria->id)
                ->where('round_id', $roundId)
                ->get()
                ->groupBy('contestant_id');
        }

        // Calculate total scores per contestant for the round
        $totalScores = [];
        foreach ($scores as $criteriaId => $criteriaScores) {
            foreach ($criteriaScores as $contestantId => $contestantScores) {
                $totalScores[$contestantId] = $totalScores[$contestantId] ?? 0;
                $totalScores[$contestantId] += $contestantScores->sum('rate');
            }
        }

        // Filter scores if a specific criterion is selected
        if ($criterionId) {
            $round->criteria = $round->criteria->where('id', $criterionId);
            $scores = [$criterionId => $scores[$criterionId]];
        }

        // Pass all the required data and the table type to the PDF view
        $pdf = Pdf::loadView('admin_dashboard.Results.print_pdf', compact('round', 'criteriaWinners', 'contestants', 'scores', 'totalScores', 'tableType'));

        // Return the generated PDF for download
        return $pdf->download('print_pdf.pdf');
    }


    public function printTable(Request $request)
    {
        $tableContent = $request->input('tableContent');
        $title = $request->input('title'); // Changed from minorAwardsCriteria

        if (!$tableContent) {
            return response('No table content received.', 400);
        }

        return view('admin_dashboard.Results.print-table', compact('tableContent', 'title'));
    }

    public function downloadPdf(Request $request)
    {
        // Increase execution time limit for PDF generation
        set_time_limit(120);

        $tableContent = $request->input('tableContent');
        $title = $request->input('title');

        // Log the received data for debugging
        Log::info('PDF Download Request', [
            'title' => $title,
            'table_content_length' => strlen($tableContent),
            'table_content_preview' => substr($tableContent, 0, 500)
        ]);

        if (!$tableContent) {
            return response()->json([
                'success' => false,
                'message' => 'No table content received. Please try again.'
            ], 400);
        }

        try {
            // Clean the table content to remove any problematic elements
            $cleanTableContent = $this->cleanTableContent($tableContent);

            // Log the cleaned content for debugging
            Log::info('Cleaned Table Content', [
                'original_length' => strlen($tableContent),
                'cleaned_length' => strlen($cleanTableContent),
                'cleaned_preview' => substr($cleanTableContent, 0, 500),
                'has_table_tag' => strpos($cleanTableContent, '<table') !== false,
                'has_tbody_tag' => strpos($cleanTableContent, '<tbody') !== false,
                'has_tr_tags' => substr_count($cleanTableContent, '<tr'),
                'has_td_tags' => substr_count($cleanTableContent, '<td')
            ]);

            // Validate that we have actual table content after cleaning
            if (empty(trim(strip_tags($cleanTableContent)))) {
                Log::error('No valid table content after cleaning');
                return response()->json([
                    'success' => false,
                    'message' => 'No valid table content found after processing.'
                ], 400);
            }

            // Additional validation - check if we have table rows
            if (substr_count($cleanTableContent, '<tr') < 2) {
                Log::error('Insufficient table rows found', [
                    'tr_count' => substr_count($cleanTableContent, '<tr'),
                    'content_preview' => substr($cleanTableContent, 0, 1000)
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Table appears to be empty or malformed. Please ensure the table contains data.'
                ], 400);
            }

            // Generate PDF from the table content using PDF-specific view
            $pdf = Pdf::loadView('admin_dashboard.Results.print-pdf', [
                'tableContent' => $cleanTableContent,
                'title' => $title ?: 'Score Report'
            ]);

            // Set paper size and orientation
            $pdf->setPaper('A4', 'landscape');

            // Set PDF options for better performance
            $pdf->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => false,
                'isPhpEnabled' => false,
                'isJavascriptEnabled' => false,
                'defaultFont' => 'Arial',
                'dpi' => 150,
                'isFontSubsettingEnabled' => true,
            ]);

            // Generate filename based on title
            $filename = $title ?
                preg_replace('/[^a-zA-Z0-9_-]/', '_', $title) . '.pdf' :
                'score_report_' . date('Y-m-d_H-i-s') . '.pdf';

            Log::info('PDF generated successfully', [
                'filename' => $filename,
                'title' => $title,
                'table_rows' => substr_count($cleanTableContent, '<tr')
            ]);

            return $pdf->download($filename);
        } catch (\Exception $e) {
            Log::error('PDF Generation Error: ' . $e->getMessage(), [
                'title' => $title,
                'table_content_length' => strlen($tableContent),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error generating PDF. Please try again or contact support if the problem persists.'
            ], 500);
        }
    }

    private function cleanTableContent($content)
    {
        // Log the original content
        Log::info('Cleaning table content', [
            'original_length' => strlen($content),
            'original_preview' => substr($content, 0, 200)
        ]);

        // Remove any JavaScript that might cause issues
        $content = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $content);

        // Remove any onclick attributes
        $content = preg_replace('/\s*onclick\s*=\s*["\'][^"\']*["\']/', '', $content);

        // Remove any other event handlers
        $content = preg_replace('/\s*on\w+\s*=\s*["\'][^"\']*["\']/', '', $content);

        // Clean up any remaining problematic attributes
        $content = preg_replace('/\s*data-[^=]*\s*=\s*["\'][^"\']*["\']/', '', $content);

        // Remove class attributes that might cause issues
        $content = preg_replace('/\s*class\s*=\s*["\'][^"\']*["\']/', '', $content);

        // Remove style attributes
        $content = preg_replace('/\s*style\s*=\s*["\'][^"\']*["\']/', '', $content);

        // Clean up extra whitespace
        $content = preg_replace('/\s+/', ' ', $content);

        // Ensure proper table structure
        if (strpos($content, '<table') !== false) {
            // Add basic table styling if missing
            if (strpos($content, 'class=') === false) {
                $content = str_replace('<table', '<table class="table"', $content);
            }
        }

        // Log the cleaned content
        Log::info('Cleaned table content', [
            'cleaned_length' => strlen($content),
            'cleaned_preview' => substr($content, 0, 200)
        ]);

        return $content;
    }

    public function approval($eventId)
    {
        // Fetch the event
        $event = Event::findOrFail($eventId);

        // Fetch judges associated with the event through the EventJudge model
        $judgeIds = EventJudge::where('event_id', $eventId)->pluck('judge_id');
        $judges = User::whereIn('id', $judgeIds)->get();

        // Fetch contestants and index them by ID for easy lookup
        $contestants = Contestant::where('event_id', $eventId)->get()->keyBy('id');

        // Fetch overall minor award scores
        $overallMinorAwardScores = overall_Minoraward_scores::where('event_id', $eventId)
            ->with('contestant') // Eager load the contestant relationship
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

        // Fetch minor awards
        $minorAwards = MinorAward::where('event_id', $eventId)->get();

        // Fetch minor award scores
        $minorAwardScores = MinorAwardScore::where('event_id', $eventId)
            ->with(['contestant', 'user', 'minorAward'])
            ->get()
            ->groupBy(['minor_award_id', 'contestant_id']);

        // Separate minor award scores by gender
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
            // Sort scores for each minor award
            arsort($maleMinorAwardScores[$minorAwardId]);
            arsort($femaleMinorAwardScores[$minorAwardId]);
        }

        // Fetch rounds
        $rounds = Round::where('event_id', $eventId)->with('criteria')->get();

        // Fetch combined judges scores
        $combinedJudgesScores = $this->getCombinedJudgesScores($eventId);

        // Ensure contestant names are included in combined judges scores
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


    public function updateEventStatus(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);
        $status = $request->input('status');

        $event->update(['status' => $status]);

        return response()->json(['message' => 'Event status updated successfully']);
    }

    public function checkEventStatus($eventId)
    {
        $event = Event::findOrFail($eventId);
        return response()->json(['status' => $event->status]);
    }
}
