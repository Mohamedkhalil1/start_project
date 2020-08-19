<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
class CheckAdminToken
{
    use GeneralTrait;

    public function __construct()
    {
        auth()->setDefaultDriver('admin-api');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user){
                return $this ->errorResponse('FFFF',__('Unauthenticated'),403);
            }
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> errorResponse('E3001','INVALID_TOKEN',403);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> errorResponse('E3001','EXPIRED_TOKEN',403);
            } else {
                return $this -> errorResponse('E3001','TOKEN_NOTFOUND',403);
            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> errorResponse('E3001','INVALID_TOKEN',403);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> errorResponse('E3001','EXPIRED_TOKEN',403);
            } else {
                return $this -> errorResponse('E3001','TOKEN_NOTFOUND',403);
            }
        }
        return $next($request);
    }
}
