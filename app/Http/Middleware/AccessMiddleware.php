<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class AccessMiddleware
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
        if ($access == 1 || $access == 2 || $access == 3) {
            return $next($request);
        } else {
            return redirect()->route("error_access");
        }
    }
}
