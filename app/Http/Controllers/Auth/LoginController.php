<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $login = $request->input('email');
    
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
    
        return [
            $field => $login,
            'password' => $request->input('password'),
        ];
    }
    

    protected function authenticated(Request $request, $user)
    {
        Log::info('User authenticated:', ['id' => $user->id, 'level' => $user->level]);
        if ($user->level === 'admin') { return redirect()->route('admin_home');}
        elseif ($user->level === 'judge') { return redirect()->route('judges_home'); } 
        elseif ($user->level === 'Sadmin') { return redirect()->route('Sadmin_home');}
        else {return redirect()->route('users_home');}
    }
    
}
