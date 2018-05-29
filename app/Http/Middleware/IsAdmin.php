<?php

namespace App\Http\Middleware;

use Closure;
use Log;
use App;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->isAdmin()) {
            return $next($request);
        }

        Log::error('Unauthorized access to admin area.');

        App::abort(403, 'Unauthorized action.');
    }
}
