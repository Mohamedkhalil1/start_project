<?php

namespace App\Http\Middleware;

use Closure;

class CheckPassword
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
        if($request->get('api_password') === null || $request->api_password !== "pwWovt7P61A2r496eeopNHg7VUQ"){
            return response()->json(['message' => 'unauthenticated'] ,401);
        }
        return $next($request);
    }
}
