<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoLogout
{
    /**
     * Handle an incoming request.
     *
     * 
     *   public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $maxInactiveTime = config('session.lifetime') * 60; // Convert minutes to seconds
            $lastActivity = session()->get('last_activity_time');

            if ($lastActivity && (time() - $lastActivity > $maxInactiveTime)) {
                Auth::logout();
                session()->flush();
                return redirect('/login')->with('message', 'You have been logged out due to inactivity.');
            }

            session()->put('last_activity_time', time());
        }
        return $next($request);
    }
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $maxInactiveTime = 5 * 60 * 60; // 5 hours in seconds
            $lastActivity = session()->get('last_activity_time');

            if ($lastActivity && (time() - $lastActivity > $maxInactiveTime)) {
                Auth::logout();
                session()->flush();
                return redirect('/login')->with('message', 'You have been logged out due to inactivity.');
            }

            session()->put('last_activity_time', time());
        }
        return $next($request);
    }
}
