<?php
// Controller: UsersController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class UsersController extends Controller
{
    public function showUsersTable(Request $request)
    {
        $keyword = $request->input('keyword');

        $users = User::query()
            ->when($keyword, function ($query, $keyword) {
                return $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%");
            })
            ->get();

        return view('admin_dashboard.users_home', compact('users'));
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3',
            'level' => ['required', Rule::in(['user', 'judge', 'admin'])],
            'profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validatedData = $request->validate($rules);

        try {
            $defaultAvatars = [
                '/avatar/man.png',
                '/avatar/women.png',
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
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'level' => $validatedData['level'],
                'profile' => $profilePath,
            ]);

            return response()->json(['message' => 'User created successfully.'], 200);
        } catch (\Exception $e) {
            return redirect()->route('showUsersTable')->with('error', 'Failed to create user. Please try again later.');
        }
    }
    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Delete the user's profile image if it exists
        if ($user->profile && file_exists(public_path($user->profile))) {
            unlink(public_path($user->profile));
        }

        $user->delete();

        return redirect()->route('showUsersTable')->with('success', 'User deleted successfully.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Handle profile image upload
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/users'), $filename);
            $user->profile = 'upload/users/' . $filename;
        }

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully');
    }
}
