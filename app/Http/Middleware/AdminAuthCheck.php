<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * AdminAuthCheck class
 */
class AdminAuthCheck
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
        if (Auth::guard($guard)->Check() && Auth::guard($guard)->user()->user_type == User::TYPE_ADMIN) {
            $blockedStatus = ['inactive', 'blocked'];
            if (in_array(Auth::guard($guard)->user()->status, $blockedStatus)) {
                return redirect('admin/logout');
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
        return redirect('/admin');
    }
}
