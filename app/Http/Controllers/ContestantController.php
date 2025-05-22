<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contestant;
use App\Models\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
class ContestantController extends Controller
{

     // ⁡⁢⁣⁢show the contestants and search contestants function⁡⁡
    public function create(Request $request, $eventId)
    {
          $event = Event::findOrFail($eventId);

          $query = Contestant::where('event_id', $eventId);
  
          if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('number', 'like', "%{$search}%");
            });
        }
          $contestants = $query->get();
        return view('admin_dashboard.Categories.add_Contestant', compact('event', 'contestants'));
    }
   
   //⁡⁢⁣⁢delete contestants function⁡
     public function destroy($id)
    {
        $contestant = Contestant::findOrFail($id);
        $eventId = $contestant->event_id;
        
        // Delete the contestant's profile image from the storage if needed
        if ($contestant->profile && file_exists(public_path($contestant->profile))) {
            unlink(public_path($contestant->profile));
        }

        $contestant->delete();

        return redirect()->route('add.contestant', $eventId)->with('success', 'Contestant deleted successfully');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
            'number' => 'required|array',
            'number.*' => 'required|integer',
            'profile' => 'required|array',
            'profile.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|array', 
            'category.*' => 'nullable|in:male,female', 
        ]);
    
        $event_id = $request->input('event_id');
        $names = $request->input('name');
        $numbers = $request->input('number');
        $categories = $request->input('category', []); 
    
        $files = $request->file('profile');
    
        foreach ($names as $index => $name) {
            if (isset($files[$index])) {
                $file = $files[$index];
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '_' . $index . '.' . $extension;
                $path = 'upload/contestants/';
                $file->move($path, $filename);
                $profilePath = $path . $filename;
    
                Contestant::create([
                    'event_id' => $event_id,
                    'name' => $name,
                    'number' => $numbers[$index],
                    'profile' => $profilePath,
                    'category' => $categories[$index] ?? null, 
                ]);
            }
        }
    
        return redirect()->route('add.contestant', $event_id)->with('success', 'Contestants added successfully');
    }
    



  //WA NMI GAMIT BACK UP LANG NAKO
    public function showContestants($eventId)
    {
        // Fetch the event along with its contestants
        $event = Event::with('contestants')->findOrFail($eventId);
         
        // Pass the event with its contestants to the view
        return view('admin_dashboard.Categories.add_event', compact('event'));
    }



    public function edit($id)
    {
        $contestant = Contestant::findOrFail($id);
        return Response::json($contestant);
    }

    public function update(Request $request, $id)
    {
        $contestant = Contestant::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|integer',
            'category' => 'nullable|in:male,female',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $contestant->name = $validatedData['name'];
        $contestant->number = $validatedData['number'];
        $contestant->category = $validatedData['category'];

        if ($request->hasFile('profile')) {
            // Delete old profile image if it exists
            if ($contestant->profile && file_exists(public_path($contestant->profile))) {
                unlink(public_path($contestant->profile));
            }

            // Upload new profile image
            $file = $request->file('profile');
            $filename = time() . '_' . $contestant->id . '.' . $file->getClientOriginalExtension();
            $path = 'upload/contestants/';
            $file->move($path, $filename);
            $contestant->profile = $path . $filename;
        }

        $contestant->save();

        return Response::json(['success' => true, 'message' => 'Contestant updated successfully']);
    }

}
