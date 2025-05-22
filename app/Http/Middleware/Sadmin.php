<?php

// app/Http/Middleware/Sadmin.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class Sadmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->level == 'Sadmin') {
            return $next($request);
        }
    
        abort(401);
    }
}


