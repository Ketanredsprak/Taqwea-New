<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Lang;
use PDOException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

/**
 * Handler
 */
class Handler extends ExceptionHandler
{

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param Illuminate\Http\Request $request 
     * @param Exception               $exception 
     * 
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $appEnv = config('app.env');

        $message = $exception->getMessage();
        $code = 400;
        
        // Validation error
        if ($exception instanceof ValidationException) {
            return parent::render($request, $exception);
        }
        // Show custom message for bad request
        // if ($exception->getCode() == 0) {
        //     $message = Lang::get('error.server_error');
        // }
        //check for maintenance mode
        if ($exception instanceof MaintenanceModeException) {
            $message = Lang::get('error.maintenance_error');
            $code = 503;
        }
        // Set message for database error
        // if ($exception instanceof PDOException) {
        //     $message = Lang::get('error.server_error');
        // }
        // Set message for database error
        if ($exception instanceof NotFoundHttpException) {
            $code = 404;
            $message = Lang::get('error.page_not_found');
        }
        // Set message for authorization exception
        if ($exception instanceof AuthorizationException) {
            $code = 403;
            $message = Lang::get('error.not_allowed');
        }
        // Set message for model not found exception
        if ($exception instanceof ModelNotFoundException) {
            $code = 404;
            $message = Lang::get('error.model_not_found');
        }

        // Send response for API and ajax call.
        if ($request->ajax() || $request->wantsJson() || $request->is('api/*')) {
            return response()->json(
                [
                    'success' => false,
                    'data' => [],
                    'message' => $message
                ],
                $code
            );
        } else {
            // Show custom message if app env is production. 
            if ($appEnv == "production") {
                if ($exception instanceof NotFoundHttpException) {
                    return response()->view('errors.404', [], 404);
                } elseif ($exception instanceof ThrottleRequestsException) {
                    return response()->view('errors.429', [], 429);
                } elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
                    return redirect()->route('show/login');
                } else {
                    return response()->view('errors.500', [], 500);
                }
            } else {
                if ($exception instanceof NotFoundHttpException) {
                    return response()->view('errors.404', [], 404);
                }
                return parent::render($request, $exception);
            }
        }
    }
}
