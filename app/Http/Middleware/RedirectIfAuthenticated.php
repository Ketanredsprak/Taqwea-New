<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request     $request 
     * @param Closure     $next 
     * @param string|null $guard 
     * 
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();
            if ($user->user_type == User::TYPE_ADMIN) {
                return redirect('/admin/dashboard');
            } elseif ($user->user_type == User::TYPE_ACCOUNTANT) {
                return redirect('/accountant/dashboard');
            } 
        }

        return $next($request);
    }
}
