<?php
namespace App\Http\Middleware;
use Closure;
use App\Models\Event;

use Illuminate\Http\Request;
use Illuminate\Http\Response; // Update the import statement for Response
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
class Judges
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse  // Update the return type
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        if (Auth::check() && Auth::user()->level == 'judge') {
            return $next($request);
        }
        abort(401);
    }
}
