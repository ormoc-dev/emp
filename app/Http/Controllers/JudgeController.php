<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Round;
use App\Models\Score;
use App\Models\Contestant;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use App\Models\JudgeApproval;

class JudgeController extends Controller
{


    public function show_events_to_judges()
    {
        $judge = Auth::user();

        // Check if the user is authenticated and is a judge
        if (!$judge || $judge->level !== 'judge') {
            abort(403, 'Unauthorized');
        }

        // Retrieve events associated with the judge that have started
        $events = $judge->events_judge()->where('event_status', 'started')->get();

        return view('judge_dashboard.view_events', ['events' => $events]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Handle profile image upload
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


        return redirect()->back()->with('success', 'Judge updated successfully');
    }

    // Create a judge for a specific event
    public function create_judge($eventId)
    {
        // Fetch the specific event based on the ID
        $event = Event::findOrFail($eventId);

        // Pass the specific event to the view
        return view('admin_dashboard.Categories.add_Judges', compact('event'));
    }

    public function store_judge(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:3',
            'password_confirmation' => 'required|same:password',
            'level' => ['required', 'string', Rule::in(['judge', 'admin', 'user'])],
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'biography' => 'nullable|string|max:1000',
            'achievements' => 'nullable|string|max:1000',
        ];

        $validatedData = $request->validate($rules);

        try {
            $defaultAvatars = [
                'avatar/boy.png',
                'avatar/woman3.png',
            ];

            // Default avatar
            $profilePath = Arr::random($defaultAvatars);

            // Handle profile image upload if provided
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $path = 'upload/users/';
                $file->move(public_path($path), $filename);
                $profilePath = $path . $filename;
            }

            // Create the user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'] ?? null,
                'password' => Hash::make($validatedData['password']),
                'level' => $validatedData['level'],
                'profile' => $profilePath,
                'biography' => $validatedData['biography'],
                'achievements' => $validatedData['achievements'],
                'created_by' => auth()->id(),
            ]);

            $judges = User::where('level', 'judge')->get();

            return redirect()->back()->with('success', 'Judge created successfully!')->with('judges', $judges);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create judge. Please try again later.');
        }
    }

    public function deleteJudge(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Delete the user's profile image if it exists
        if ($user->profile && file_exists(public_path($user->profile))) {
            unlink(public_path($user->profile));
        }

        $user->delete();

        return redirect()->back()->with('success', 'Judge and associated data deleted successfully');
    }

    public function submitRates(Request $request)
    {
        $rates = $request->input('rates');
        $userId = auth()->user()->id; // Assuming user (judge) is logged in

        foreach ($rates as $contestantId => $rate) {
            Score::create([
                'contestant_id' => $contestantId,
                'user_id' => $userId,
                'rate' => $rate,
            ]);
        }

        return redirect()->back()->with('success', 'Rates submitted successfully!');
    }

    public function showResults($eventId)
    {
        $event = Event::with(['contestants.scores'])->findOrFail($eventId);

        foreach ($event->contestants as $contestant) {
            $averageScore = $contestant->scores->avg('rate');
            $contestant->average_score = $averageScore ?? 0; // Ensure there's always a value
            // Debugging output
            logger()->info("Contestant {$contestant->name} has an average score of {$averageScore}");
        }

        return view('judge_dashboard.Rate', compact('event'));
    }
}
