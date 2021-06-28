<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class SessionMiddleware
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
        if(Auth::check()) {
            $user = Auth::user();
            $access = $user->access;
            view()->share(["username" => $user->username, "id_auth" => $user->id]);
        }
        else {
            $access = 0;
        }
        // return redirect()->route("message");
        view()->share(["access" => $access]);

        return $next($request);
    }
}
