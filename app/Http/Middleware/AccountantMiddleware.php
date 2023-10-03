<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * AccountantMiddleware middleware
 */
class AccountantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request      $request 
     * @param Closure      $next 
     * @param string|array $guard 
     * 
     * @return mixed
     */
    public function handle($request, Closure $next, $guard)
    {
        if (Auth::guard($guard)->Check() && (Auth::guard($guard)->user()->user_type == User::TYPE_ACCOUNTANT)) {
            $blockedStatus = ['inactive', 'blocked'];
            if (in_array(Auth::guard($guard)->user()->status, $blockedStatus)) {
                return redirect('accountant/logout');
            }
            $request['user'] = Auth::guard($guard)->user();
            return $next($request);
        }
        $type = $request->headers->get('Content-Type');
        if ($type == 'application/json' || $request->ajax()) {
            return response()->json(
                [
                    'success' => false,
                    'data' => [],
                    'message' => ''
                ],
                401
            );
        }
        return redirect('/accountant/login');
    }
}
