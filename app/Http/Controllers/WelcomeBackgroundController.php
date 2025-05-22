<?php

namespace App\Http\Controllers;

use App\Models\WelcomeBackground;
use Illuminate\Http\Request;
use App\Models\VideoHighlight;
use App\Models\Event;

class WelcomeBackgroundController extends Controller
{ 

    public function Show_to_welcome_page()
    {
        
        $events = Event::with('timeSchedule')
            ->where('date_start', '>=', now())
            ->orderBy('date_start', 'asc')
            ->take(3)
            ->get();
        $background = WelcomeBackground::where('is_active', true)->first();
        $videos = VideoHighlight::latest()->take(3)->get(); // Get the 3 most recent videos
        
        return view('welcome', compact('background', 'videos','events'));
    }


    public function settings()
    {
        $background = WelcomeBackground::where('is_active', true)->first();
        return view('SupperAdmin_dashboard.pages.WelcomeBg', compact('background'));
    }

   
    
    public function update(Request $request)
    {
        $request->validate([
            'background_image' => 'required|image|mimes:jpg,png,webp|max:2048'
        ]);
    
        try {
            // Get the current active background
            $currentBackground = WelcomeBackground::where('is_active', true)->first();
    
            // Delete the old image file if it exists
            if ($currentBackground) {
                $oldImagePath = public_path($currentBackground->background_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                // Delete the old record from database
                $currentBackground->delete();
            }
    
            // Handle new image upload
            $image = $request->file('background_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Move the image to public/upload/welcome_image directory
            $image->move(public_path('upload/welcome_image'), $imageName);
            
            // Store the relative path in database
            $imagePath = 'upload/welcome_image/' . $imageName;
    
            // Create new background record
            WelcomeBackground::create([
                'background_image' => $imagePath,
                'is_active' => true
            ]);
    
            return redirect()->back()->with('success', 'Background image updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update background image: ' . $e->getMessage());
        }
    }
}