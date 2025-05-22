<?php

namespace App\Http\Controllers;

use App\Models\VideoHighlight;
use Illuminate\Http\Request;

class VideoHighlightController extends Controller
{
    public function index()
    {
        $videos = VideoHighlight::all();
        return view('SupperAdmin_dashboard.pages.VideoHighlight', compact('videos'));
    }

    public function create()
    {
        return view('SupperAdmin_dashboard.pages.VideoHighlight.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'video_url' => 'required|url',
        ]);

        VideoHighlight::create($request->all());

        return redirect()->route('video-highlights.index')
            ->with('success', 'Video highlight created successfully');
    }

    public function edit($id)
    {
        $video = VideoHighlight::findOrFail($id);
        return response()->json($video);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'video_url' => 'required|url',
        ]);

        $video = VideoHighlight::findOrFail($id);
        $video->update($request->all());

        return redirect()->route('video-highlights.index')
            ->with('success', 'Video highlight updated successfully');
    }

    public function destroy($id)
    {
        $video = VideoHighlight::findOrFail($id);
        $video->delete();

        return redirect()->route('video-highlights.index')
            ->with('success', 'Video highlight deleted successfully');
    }
}