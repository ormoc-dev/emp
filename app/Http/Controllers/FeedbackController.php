<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Mail\FeedbackThankYouMail;use Illuminate\Support\Facades\Mail;
class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

        Feedback::create($validatedData);

       
        Mail::to($validatedData['email'])->send(new FeedbackThankYouMail($validatedData));

        return response()->json(['message' => 'Feedback submitted successfully'], 200);
    }
}