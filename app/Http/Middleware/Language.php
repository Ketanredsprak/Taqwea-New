<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request 
     * @param Closure $next 
     * 
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $language = (getLanguageInCookie()) ?? config('app.locale');
        setUserLanguage($language);
        return $next($request);
    }
}
