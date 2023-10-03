<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Request;

/**
 * JwtMiddleware
 */
class JwtMiddleware extends BaseMiddleware
{

    /**
     * Method handle
     *
     * @param Request $request [explicite description]
     * @param Closure $next    [explicite description]
     *
     * @return void
     */
    public function handle($request, Closure $next)
    {
        try {
            $versionCheck = checkAppVersion($request);
            if ($versionCheck && !$versionCheck['success']) {
                return response()->json($versionCheck, 403);
            }

            $user = JWTAuth::parseToken()->authenticate();
            // Update user time zone
            if ($request->header('time-zone') 
                && $request->header('time-zone') !== $user->time_zone
            ) {
                updateUserTimeZOne(
                    $user->id, $request->header('time-zone')
                );
            }
            if ($user && in_array($user->status, [User::STATUS_BLOCKED,User::STATUS_INACTIVE])) {
                invalidateToken($request);
                return response()->json(
                    [
                        'success' => false,
                        'data' => [],
                        'error' => ['message' => 'Token is Expired']
                    ],
                    401
                );
            }
            setUserLanguage($request->header('language'));
            $request['user'] = $user;
        } catch (Exception $e) {
            $message = '';
            $code = 400;
            if ($e instanceof TokenInvalidException) {
                $message =  'Your session has expired.';
                $code = 401;
            } else if ($e instanceof TokenExpiredException) {
                $message =  'Your session has expired.';
                $code = 401;
            } else {
                $message =  'Authorization Token not found';
            }
            return response()->json(
                [
                    'success' => false,
                    'data' => [],
                    'error' => ['message' => $message]
                ],
                $code
            );
        }
        return $next($request);
    }
}
