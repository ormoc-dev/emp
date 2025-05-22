<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users_vote;
use App\Models\Score;
use App\Models\Contestant;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use App\Models\TimeStatus;
use App\Models\TimeSchedule;
use Carbon\Carbon;

class UsersVoteController extends Controller
{
    public function getContestantRankings($eventId)
    {
        try {
            // Get contestants with their vote counts for this event
            $contestants = Contestant::where('contestants.event_id', $eventId)
                ->select(
                    'contestants.id',
                    'contestants.name',
                    'contestants.profile',
                    DB::raw('COALESCE(SUM(users_votes.vote_count), 0) as total_votes')
                )
                ->leftJoin('users_votes', function ($join) {
                    $join->on('contestants.id', '=', 'users_votes.contestant_id');
                })
                ->groupBy('contestants.id', 'contestants.name', 'contestants.profile')
                ->orderByDesc('total_votes')
                ->get();

            $totalVotes = $contestants->sum('total_votes');

            return response()->json([
                'success' => true,
                'contestants' => $contestants->map(function ($contestant) use ($totalVotes) {
                    return [
                        'id' => $contestant->id,
                        'name' => $contestant->name,
                        'profile' => $contestant->profile ? asset($contestant->profile) : null,
                        'votes_count' => (int)$contestant->total_votes,
                        'percentage' => $totalVotes > 0 ? round(($contestant->total_votes / $totalVotes) * 100, 1) : 0
                    ];
                }),
                'totalVotes' => $totalVotes
            ]);
        } catch (\Exception $e) {
            Log::error('Rankings Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to load rankings',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function vote(Request $request, $contestantId)
    {
        $userId = auth()->id();
        $event_id = $request->event_id;
        $user = User::find($userId);
        $event = Event::findOrFail($event_id);

        // Check if time schedule exists
        if (!$event->timeSchedule) {
            return redirect()->back()->with('time_error', 'Voting is not yet open. Please wait for the schedule to be announced.');
        }

        // Get the voting category and its points per vote
        $votingCategory = $event->votingCategories()
            ->where('is_active', true)
            ->first();

        if (!$votingCategory) {
            return redirect()->back()->with('error', 'No active voting category found for this event.');
        }

        $pointsPerVote = $votingCategory->points_per_vote;

        // Time check logic
        $now = now();
        $start = Carbon::parse($event->timeSchedule->time_start);
        $end = Carbon::parse($event->timeSchedule->time_end);

        if (!$now->between($start, $end)) {
            return redirect()->back()->with('time_error', 'Voting is currently closed. Voting period is from ' .
                $start->format('M d, Y g:i A') . ' to ' .
                $end->format('M d, Y g:i A'));
        }

        $existingVote = Users_vote::where('user_id', $userId)
            ->where('event_id', $event_id)
            ->where('contestant_id', $contestantId)
            ->first();

        if (!$existingVote) {
            // First vote for this contestant
            if ($user->remaining_votes > 0 || Users_vote::where('user_id', $userId)->where('event_id', $event_id)->count() == 0) {
                Users_vote::create([
                    'contestant_id' => $contestantId,
                    'user_id' => $userId,
                    'event_id' => $event_id,
                    'vote_count' => $pointsPerVote // Set initial vote count to points per vote
                ]);

                if (Users_vote::where('user_id', $userId)->where('event_id', $event_id)->count() > 1) {
                    $user->remaining_votes -= 1;
                    $user->save();
                }

                return redirect()->back()->with('success', 'Your vote has been recorded for ' . $pointsPerVote . ' points. You have ' . $user->remaining_votes . ' votes remaining.');
            } else {
                return redirect()->back()->with('error', 'You have used all your votes. Would you like to purchase more?');
            }
        } else {
            // User has already voted for this contestant
            if ($user->remaining_votes > 0) {
                // Increment the vote count by points per vote
                $existingVote->increment('vote_count', $pointsPerVote);

                $user->remaining_votes -= 1;
                $user->save();

                return redirect()->back()->with('success', 'Your additional vote has been recorded for ' . $pointsPerVote . ' points. You have ' . $user->remaining_votes . ' votes remaining.');
            } else {
                return redirect()->back()->with('error', 'You have used all your votes. Would you like to purchase more?');
            }
        }
    }

    public function calculateFinalScore($contestantId, $eventId)
    {
        // Fetch all scores for the contestant
        $scores = Score::where('contestant_id', $contestantId)->get();

        // Calculate the average score from judges
        $averageJudgeScore = $scores->avg('rate');

        // Calculate user votes count
        $contestantVotes = Users_vote::where('contestant_id', $contestantId)->where('event_id', $eventId)->count();

        // Each user vote contributes 1 point
        $userVotesScore = $contestantVotes * 1; // Each user vote counts as 1 point

        // Combine judge score with user votes score
        $finalScore = $averageJudgeScore + $userVotesScore;

        return $finalScore;
    }








    public function store_comment(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'event_id' => 'required|exists:events,id',
        ]);
    
        // Check for bad words
        $badWords = config('badwords.words', [
            'fuck', 'shit', 'ass', 'bitch', 'bastard',
            // Add more bad words to the array
        ]);
    
        $content = strtolower($request->input('content'));
        
        // Check if the comment contains any bad words
        foreach ($badWords as $word) {
            if (str_contains($content, strtolower($word))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your comment contains inappropriate language. Please revise it.'
                ], 422);
            }
        }
    
        // If no bad words found, create the comment
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->event_id = $request->input('event_id');
        $comment->user_id = auth()->user()->id;
        $comment->save();
    
        // Load the user relationship
        $comment->load('user');
    
        return response()->json([
            'success' => true,
            'comment' => $comment,
            'message' => 'Comment posted successfully.'
        ]);
    }


    public function destroy_comment(Comment $comment)
    {
        $currentUserId = auth()->user()->id;
        $commentOwnerId = $comment->user_id;

        if ($currentUserId !== $commentOwnerId) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        try {
            $comment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting comment'
            ], 500);
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users_dashboard.profile_info', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() != $id) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

        try {
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $path = 'upload/users/';
                $newProfilePath = $path . $filename;

                // Delete the old profile image if it exists
                if ($user->profile && file_exists(public_path($user->profile))) {
                    unlink(public_path($user->profile));
                }

                // Move the new file to the public directory
                $file->move(public_path($path), $filename);

                // Update user's profile image path
                $user->profile = $newProfilePath;
            }

            // Update other user details
            $user->name = $request->input('name');
            $user->email = $request->input('email');

            $user->save();

            return response()->json([
                'message' => 'Profile updated successfully!',
                'profile' => $request->hasFile('profile') ? asset($user->profile) : null
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating profile'], 500);
        }
    }


    public function store(Request $request, $event_id)
    {
        // Validate the form data
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Check if time_status already exists for the event
        $existingTimeStatus = TimeStatus::where('event_id', $event_id)->first();
        if ($existingTimeStatus) {
            return redirect()->back()->with('error', 'Time status has already been set for this event!');
        }

        // Store the start_time and end_time in the time_statuses table
        $timeStatus = new TimeStatus();
        $timeStatus->event_id = $event_id;  // Link to the event
        $timeStatus->start_time = $request->start_time;
        $timeStatus->end_time = $request->end_time;
        $timeStatus->save();

        return redirect()->back()->with('success', 'Time status updated successfully!');
    }

    public function edit_time($event_id)
    {
        // Retrieve the existing time status for the event
        $timeStatus = TimeStatus::where('event_id', $event_id)->first();

        // Check if time_status exists
        if (!$timeStatus) {
            return redirect()->back()->with('error', 'No time status found for this event.');
        }

        // Return view to edit time with the existing time data
        return view('edit_time_status', compact('timeStatus'));
    }

    public function update_time(Request $request, $event_id)
    {
        // Validate the form data
        $request->validate([
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Update the time_status for the event
        $timeStatus = TimeStatus::where('event_id', $event_id)->first();
        if ($timeStatus) {
            $timeStatus->start_time = $request->start_time;
            $timeStatus->end_time = $request->end_time;
            $timeStatus->save();

            return redirect()->back()->with('success', 'Time status updated successfully!');
        }

        return redirect()->back()->with('error', 'No time status found for this event.');
    }
}
