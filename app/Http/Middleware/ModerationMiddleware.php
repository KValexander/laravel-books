<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class ModerationMiddleware
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
        $user = Auth::user();
        $access = $user->access;
        if ($access == 1 || $access == 2) {
            return $next($request);
        } else {
            return redirect()->route("error_access");
        }
    }
}
