<?php

namespace App\Http\Controllers\Auth\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\Admin\LoginRequest;
use App\Repositories\UserRepository;
use App\Repositories\UserDeviceRepository;
use App\Repositories\CartRepository;
use App\Services\SocialMediaService;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
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
    protected $cartRepository;
    protected $socialMediaService;
    protected $userDeviceRepository;

    /**
     * Create a new controller instance.
     *
     * @param UserRepository     $userRepository 
     * @param CartRepository     $cartRepository 
     * @param SocialMediaService $socialMediaService 
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        CartRepository $cartRepository,
        SocialMediaService $socialMediaService,
        UserDeviceRepository $userDeviceRepository
    ) {
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
        $this->socialMediaService = $socialMediaService;
        $this->userDeviceRepository = $userDeviceRepository;
    }

    /**
     * Function showLoginForm
     *
     * @return void
     */
    public function showLoginForm()
    {
        return view('frontend.auth.login');
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
        try {
            $request = app()->request;
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                $this->sendLockoutResponse($request);
            }
            $user = $this->userRepository
                ->getUserByAttribute($request->all(), User::STATUS_ACTIVE);

            $this->incrementLoginAttempts($request);

            if (!empty($user)) {
                if (!Hash::check($request->password, $user->password)) {
                    return $this->sendFailedLoginResponse($request);
                } else if ($user->status == User::STATUS_INACTIVE) {
                    return $this->apiErrorResponse(
                        trans('message.inactive_account'),
                        400
                    );
                } else if ($user->status == User::STATUS_BLOCKED) {
                    return $this->apiErrorResponse(
                        trans('message.blocked_account'),
                        400
                    );
                } else if (!in_array(
                    $user->user_type,
                    [
                        User::TYPE_STUDENT,
                        User::TYPE_TUTOR
                    ]
                )
                ) {
                    return $this->sendFailedLoginResponse($request);
                } else {
                    if ($this->attemptLogin($request, 'web')) {
                        
                        // $userDevice = $this->userDeviceRepository->getDeviceByUser($user->id);
                        // foreach ($userDevice as  $device) {
                        //     if ($device->access_token) {
                        //         invalidateTokenString($device->access_token);
                        //     }
                            
                        // }
                        // $this->userDeviceRepository->updateDeviceByUser(["device_id" => null], $user->id);
                        return $this->sendLoginResponse($request, $user);
                    }
                }
            } else {
                return $this->sendFailedLoginResponse($request);
            }
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

    /**
     * Function sendLoginResponse
     *
     * @param Request $request [explicite description]
     * @param User    $user    [explicite description]
     * 
     * @return void
     */
    protected function sendLoginResponse(Request $request, $user)
    {
        $data['language'] = config('app.locale');
        $this->userRepository->updateUser($data, $user->id);

        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        // Reset force logut
        $data['is_force_logout'] = 0;
        $this->userRepository->updateUser($data, $user->id);

        if ($user->user_type === User::TYPE_STUDENT) {
            if (@$request->item_id) {
                $this->addItemToCart($request, $user);
            }
            $redirectionUrl = url('student/dashboard');
        } else if ($user->user_type === User::TYPE_TUTOR) {

            if ($user->is_verified) {
                $redirectionUrl = url('tutor/dashboard');
            } else {

                // Send otp to user
                $user = $this->userRepository->sendOtp(
                    [
                        'email' => $user->email
                    ],
                    'registration'
                );

                // Redirect on verification screen
                $token = Crypt::encryptString($user->id);
                $redirectionUrl = route('verify-otp', ['token' => $token]);
            }
        } else {
            $redirectionUrl = url('/');
        }

        if ($request->expectsJson()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => trans('message.log_in'),
                    'redirectionUrl' => $redirectionUrl
                ]
            );
        } else {
            $message = trans('message.log_in');
            session()->flash('success', $message);
            return redirect($redirectionUrl);
        }
    }

    /**
     * Add item to user cart
     * 
     * @param Request $request 
     * @param $user 
     * 
     * @return Void 
     */
    public function addItemToCart($request, $user)
    {

        $params  = [];
        if ($request->item_type == 'class') {
            $params['class_id'] = Crypt::decryptString($request->item_id);
        }

        if ($request->item_type == 'blog') {
            $params['blog_id'] = Crypt::decryptString($request->item_id);
        }
        $check = $this->cartRepository->checkItemExistInCart($user, $params);
        if (empty($check)) {
            $this->cartRepository->createCart($params);
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
     * 
     * @return void
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(
                [
                    'success' => false,
                    'data' => [],
                    'message' => trans('message.invalid_credentials')
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
        session()->flash('success', trans('message.log_out'));

        return redirect('/')
            ->with('message', 'You are now signed out')
            ->with('status', 'success')
            ->withInput();
    }

    /**
     * Redirect the user to the social platform authentication page.
     *
     * @param string $driver 
     * 
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider(string $driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from social platform.
     * 
     * @param Request $request 
     * @param string  $driver 
     * 
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, string $driver)
    {
        $post = [];
        $userData = $this->socialMediaService->getUser($driver, $post);
        $user = new User();
        if (!empty($userData['email'])) {
            $checkUser['email'] = $userData['email'];
            $user = $this->userRepository
                ->getUserByAttribute($checkUser);
            $userData['name'] = $user ? $user->name : '';
            $user = $this->userRepository->createUser($userData, false, true);
        }

        if (!$this->checkUserRequiredDetail($user)) {
            $token = Crypt::encryptString($user->id);
            return redirect('sign-up/complete?token=' . $token);
        } else {
            Auth::login($user);
        }

        return $this->sendLoginResponse($request, $user);
    }

    /**
     * Check user required details
     * 
     * @param $user 
     * 
     * @return bool
     */
    public function checkUserRequiredDetail($user)
    {
        $check = true;
        $name = @$user->name;
        if (empty($user->user_type) || empty($user->email)
            || empty($name) || empty($user->gender)
        ) {
            $check = false;
        }
        return $check;
    }
}
