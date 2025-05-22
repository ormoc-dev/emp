<?php

namespace App\Http\Controllers;

use App\Models\VotingCategory;
use App\Models\VotingSettings;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class VotingCategoryController extends Controller
{

    public function store(Request $request, Event $event)
    {
        try {
            $validated = $request->validate([
                'category_name' => 'required|string|max:255',
                'points_per_vote' => 'required|integer|min:1',
                'category_icon' => 'required|string',
                'event_id' => 'required|exists:events,id'
            ]);
    
            VotingCategory::create([
                'event_id' => $event->id,
                'category_name' => $validated['category_name'],
                'points_per_vote' => $validated['points_per_vote'],
                'category_icon' => $validated['category_icon'],
                'is_active' => true
            ]);
    
            return redirect()->back()->with('success', 'Voting category created successfully');
    
        } catch (\Exception $e) {
            Log::error('Failed to create voting category:', [
                'error' => $e->getMessage(),
                'event_id' => $event->id,
                'request_data' => $request->all()
            ]);
    
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create voting category: ' . $e->getMessage());
        }
    }
    
    public function destroy(Event $event, VotingCategory $category)
    {
        try {
            if ($category->event_id !== $event->id) {
                throw new \Exception('Category does not belong to this event');
            }
    
            $category->delete();
            
            return redirect()->back()->with('success', 'Voting category deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }
    
    public function toggleStatus(Event $event, VotingCategory $category)
    {
        try {
            $category->update([
                'is_active' => !$category->is_active
            ]);
    
            return redirect()->back()->with('success', 'Category status updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }
    public function getEventCategories(Event $event): JsonResponse
    {
        try {
            $categories = $event->votingCategories()
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories: ' . $e->getMessage()
            ], 422);
        }
    }
}