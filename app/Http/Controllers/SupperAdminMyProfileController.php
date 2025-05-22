<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupperAdminMyProfileController extends Controller
{
    //

    public function index_MyProfile()
    {
        return view('SupperAdmin_dashboard.Authentication.MyProfile');
    }


    public function update_profile(Request $request)
    {
        // Get the currently authenticated user
        $user = auth()->user();
    
        // Handle profile image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
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
    
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
  
    
    public function change_password(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'old_password' => 'required|min:3|max:100',
            'new_password' => 'required|min:3|max:100',
            'new_password_confirmation' => 'required|same:new_password'
        ]);
    
        // Get the current authenticated user
        $current_user = auth()->user();
    
        // Check if the old password matches the current user's password
        if (Hash::check($request->old_password, $current_user->password)) {
            // Update the password directly using DB facade
            DB::table('users')
                ->where('id', $current_user->id)
                ->update(['password' => Hash::make($request->new_password)]);
    
            return redirect()->back()->with('success_change_password', 'Password successfully updated.');
        } else {
            // If the old password does not match, redirect back with an error message
            return redirect()->back()->with('error_change_password', 'Old password does not match.');
        }
    }
}
