<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;

/**
 * NoToken
 */
class NoToken  extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request 
     * @param \Closure $next 
     * 
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        setUserLanguage($request->header('language'));
    
        return $next($request);
    }
}
