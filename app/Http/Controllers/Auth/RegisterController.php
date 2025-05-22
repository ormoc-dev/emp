<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    // ... existing code ...

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */

    protected function registered(Request $request, $user)
    {
        // Logout the user immediately after registration
        $this->guard()->logout();

        // Redirect to the login page with a success message
        return redirect($this->redirectPath())
            ->with('success', 'Registration successful. Please log in.');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users',
            
        
        ],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
            'profile' => ['nullable', 'string', 'max:255'],
        ]);
    }

    /**
     * protected function validator(array $data)

   return Validator::make($data, [
       'name' => ['required', 'string', 'max:255'],
       'email' => [
           'required', 
           'string', 
           'email', 
           'max:255', 
           'unique:users',
           function ($attribute, $value, $fail) {
               $domain = substr(strrchr($value, "@"), 1);
               if ($domain !== 'wlcormoc.edu.ph') {
                   $fail('The email must be a valid wlcormoc.edu.ph address.');
               }
           },
       ],
       'password' => ['required', 'string', 'min:3', 'confirmed'],
       'profile' => ['nullable', 'string', 'max:255'],
   ]);

     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Define an array of default avatar URLs
        $defaultAvatars = [
            'avatar/boy.png',
            'avatar/woman3.png',

        ];

        // Randomly select a default avatar URL
        $defaultAvatar = Arr::random($defaultAvatars);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile' => $defaultAvatar,
        ]);
    }
}
