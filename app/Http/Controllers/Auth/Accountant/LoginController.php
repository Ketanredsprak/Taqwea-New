<?php

namespace App\Http\Controllers\Auth\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\UserRepository;
use App\Repositories\UserDeviceRepository;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Support\Facades\Session;
use Exception;

/**
 * LoginController class
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $userRepository;
    protected $userDeviceRepository;

    /**
     * Create a new controller instance.
     * 
     * @param UserRepository       $userRepository 
     * @param UserDeviceRepository $userDeviceRepository 
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, UserDeviceRepository $userDeviceRepository)
    {
        $this->userRepository = $userRepository;
        $this->userDeviceRepository = $userDeviceRepository;
    }

    /**
     * Function showLoginForm
     *
     * @return void
     */
    public function showLoginForm()
    {
        setUserLanguage('en');
        return view('accountant.auth.login');
    }

    /**
     * Function login
     *
     * @param LoginRequest $loginRequest 
     * 
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $loginRequest)
    {
        $request = app()->request;

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $user = $this->userRepository
            ->getUserByAttribute($request->all());

        $this->incrementLoginAttempts($request);

        if (!empty($user)) {
            if (!Hash::check($request->password, $user->password)) {
                return $this->sendFailedLoginResponse($request);
            } else if ($user->status == 'inactive') {
                return response()->json(
                    [
                        'success' => false,
                        'data' => [],
                        'message' => trans('message.inactive_account')
                    ],
                    401
                );
            } else if (!in_array($user->user_type, [User::TYPE_ACCOUNTANT])) {
                return $this->sendFailedLoginResponse($request);
            } else {
                if ($this->attemptLogin($request, 'web')) {
                    return $this->sendLoginResponse($request);
                }
            }
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * Function sendLoginResponse
     *
     * @param Request $request [explicite description]
     * 
     * @return void
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);
        if ($request->expectsJson()) {
            $redirectionUrl = url('accountant/dashboard');
            return response()->json(
                [
                    'success' => true,
                    'message' => 'Login is successfully.',
                    'redirectionUrl' => $redirectionUrl
                ]
            );
        }
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param Request $request 
     * @param string  $guard 
     * 
     * @return bool
     */
    protected function attemptLogin(Request $request, string $guard)
    {
        $remember_me = $request->has('remember');
        $username = $request->email;
        $password = $request->password;
        if ($remember_me) {
            Cookie::queue(
                Cookie::make(
                    'login_email',
                    $username,
                    time() + (365 * 24 * 60 * 60)
                )
            );
            Cookie::queue(
                Cookie::make(
                    'login_password',
                    $password,
                    time() + (365 * 24 * 60 * 60)
                )
            );
            Session::put('timezone', $request->tz);
        } else {
            Cookie::queue(Cookie::forget('login_email'));
            Cookie::queue(Cookie::forget('login_password'));
        }

        return $this->guard($guard)
            ->attempt($this->credentials($request), $remember_me);
    }

    /**
     * Function credentials
     *
     * @param Request $request [explicite description]
     * 
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['status'] = ['active'];
        return $credentials;
    }

    /**
     * Function sendFailedLogResponse
     *
     * @param Request $request [explicite description]
     * @param string  $message [explicite description]
     * 
     * @return void
     */
    protected function sendFailedLoginResponse(Request $request, $message = "")
    {
        $message = ($message) ? $message : trans('message.invalid_credentials');
        if ($request->expectsJson()) {
            return response()->json(
                [
                    'success' => false,
                    'data' => [],
                    'message' => $message
                ],
                401
            );
        }
    }

    /**
     * Function username to be used by the controller.
     *
     * @return void
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @param string $guard 
     * 
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard(string $guard)
    {
        return Auth::guard($guard);
    }

    /**
     * Function logout
     *
     * @param Request $request 
     * 
     * @return void
     */
    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $user = Auth::user();
            $this->userDeviceRepository->destroy($user->id, 'web');
            $this->guard('web')->logout();
        }
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/accountant/login')
            ->with('message', 'You are now signed out')
            ->with('status', 'success')
            ->withInput();
    }
}
