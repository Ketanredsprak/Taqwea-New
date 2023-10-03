<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Closure;

/**
 * CheckLogin class 
 */
class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request 
     * @param Closure $next 
     * @param string  $guard 
     * 
     * @return mixed
     */
    public function handle($request, Closure $next, string $guard)
    {
        if (Auth::guard($guard)->check()) {
            $user = Auth::guard($guard)->user();
            $userType = Auth::guard($guard)->user()->user_type;
            if ($userType == User::TYPE_ADMIN) {
                return redirect('/admin/dashboard');
            } elseif ($userType == User::TYPE_STUDENT) {
                return redirect('/student/dashboard');
            } elseif ($userType == User::TYPE_TUTOR) {
                if ($user->is_verified) {
                    return redirect('/tutor/dashboard');
                } else {
                    return redirect('/login');
                }
            } elseif ($userType == User::TYPE_ACCOUNTANT) {
                return redirect('/accountant/dashboard');
            }
        } 
        $response = $next($request);
        return  $response->header(
            'Cache-Control',
            'nocache, no-store, max-age=0, must-revalidate'
        )->header('Pragma', 'no-cache')
            ->header('Expired', '0');
    }
}
