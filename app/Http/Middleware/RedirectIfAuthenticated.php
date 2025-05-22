<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            switch ($user->level) {
                case 'admin':
                    return redirect()->route('admin_home');
                case 'judge':
                    return redirect()->route('judges_home');
                case 'Sadmin':
                    return redirect()->route('Sadmin_home');
                default:
                    return redirect()->route('users_home');
            }
        }

        return $next($request);
    }
}
