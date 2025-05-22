<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
class SupperAdminMessageController extends Controller
{
    public function __construct()
    {
        $feedbackCount = DB::table('feedback')->count();
        View::share('feedbackCount', $feedbackCount);
    }
    
    public function index_message()
    {
        $feedbacks = DB::table('feedback')->orderBy('created_at', 'desc')->get()->map(function ($feedback) {
            $feedback->created_at = Carbon::parse($feedback->created_at); 
            return $feedback;
        });
    
         $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
    return view('SupperAdmin_dashboard.Message', ['feedbacks' => $feedbacks]);
    }
  
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id); 
        $feedback->delete();
        return redirect()->route('supper.admin.messages')->with('success', 'Feedback deleted successfully.');
    }
   

    public function deleteMultiple(Request $request)
    {
        if (!$request->has('ids')) {
            return response()->json(['error' => 'No feedback selected.'], 400);
        }
    
        $ids = $request->input('ids');
        $deletedCount = Feedback::whereIn('id', $ids)->delete();
    
        if ($deletedCount > 0) {
            return response()->json(['success' => "$deletedCount feedback(s) deleted successfully."]);
        } else {
            return response()->json(['error' => 'Failed to delete selected feedback.'], 500);
        }
    }
}
