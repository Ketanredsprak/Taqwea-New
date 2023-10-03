<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StudentAuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $guard)
    {
        if (Auth::guard($guard)->Check() && (Auth::guard($guard)->user()->user_type == User::TYPE_STUDENT)) {
            
            // Update user time zone
            if ($request->header('time-zone') 
                && $request->header('time-zone') !== Auth::guard($guard)->user()->time_zone
            ) {
                updateUserTimeZOne(
                    Auth::guard($guard)->user()->id, $request->header('time-zone')
                );
            }

            $blockedStatus = ['inactive', 'blocked'];
            if (in_array(Auth::guard($guard)->user()->status, $blockedStatus)) {
                return redirect('logout');
            }
            if (Auth::guard($guard)->user()->is_force_logout) {
                return redirect('logout');
            }
            $request['user'] = Auth::guard($guard)->user();
            $response = $next($request);
            return  $response->header(
                'Cache-Control',
                'nocache, no-store, max-age=0, must-revalidate'
            )->header('Pragma', 'no-cache')
                ->header('Expired', '0');
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
        return redirect('/login');
    }
}
