<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SupperAdminPasswordResetMail;

class SupperAdminForgotPasswordController extends Controller
{
    public function index_ForgotPassword()
    {
        $tabulators = User::where('level', 'admin')->get();
        $audience = User::where('level', 'user')->orWhere('level', null)->get();

        return view('SupperAdmin_dashboard.Authentication.ForgotPassword', [
            'tabulators' => $tabulators,
            'audience' => $audience
        ]);
    }

    public function resetPassword($userId, $userType)
    {
        try {
            // Validate user type and get user
            $user = User::where('id', $userId);
            
            if ($userType === 'tabulator') {
                $user = $user->where('level', 'admin');
            } elseif ($userType === 'audience') {
                $user = $user->where('level', 'user');
            } else {
                throw new \Exception('Invalid user type');
            }

            $user = $user->firstOrFail();

            // Generate a new password
            $newPassword = Str::random(8);

            // Hash and save the new password
            $user->password = Hash::make($newPassword);
            $user->save();

            // Send password reset email
            try {
                Mail::to($user->email)->send(new SupperAdminPasswordResetMail($user->name, $newPassword));

                return response()->json([
                    'success' => true,
                    'message' => 'Password has been reset successfully.',
                    'new_password' => $newPassword
                ]);
            } catch (\Exception $mailError) {
                Log::error('Mail Error: ' . $mailError->getMessage());

                return response()->json([
                    'success' => false,
                    'message' => 'Error sending email: ' . $mailError->getMessage()
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Reset Password Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}