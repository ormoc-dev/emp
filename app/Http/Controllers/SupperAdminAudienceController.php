<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class SupperAdminAudienceController extends Controller
{
    public function index_audience()
    {
        $users = User::where('level', 'user')->orWhereNull('level')->get();
    
        return view('SupperAdmin_dashboard.Authentication.Audience', [
            'users' => $users
        ]);
    }
    

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3',
            'level' => ['required', Rule::in(['user', 'judge', 'admin'])],
        ];

        $validatedData = $request->validate($rules);

        try {
            // Create the user
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'level' => $validatedData['level'],
            ]);
            
            return response()->json(['success' => 'User created successfully.'], 200);
        } catch (\Exception $e) {
            return redirect()->route('audience')->with('error', 'Failed to create user. Please try again later.');
        }
    }



    public function destroy($id)
    {
        $User = User::findOrFail($id);
        $User->delete();
    
        // Redirect back with a success message
        return redirect()->route('audience')->with('success', 'User deleted successfully.');
    }
}