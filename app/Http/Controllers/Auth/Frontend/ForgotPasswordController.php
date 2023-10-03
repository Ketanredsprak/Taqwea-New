<?php

namespace App\Http\Controllers\Auth\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Repositories\UserRepository;
use App\Http\Requests\Auth\VerifyEmailRequest;
use App\Http\Requests\Auth\CreatePasswordRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Exception;

class ForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;

    protected $userRepository;

    /**
     * Function __construct 
     *
     * @param UserRepository $userRepository [explicite description]
     * 
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest');
        $this->userRepository = $userRepository;
    }

    /**
     * Show forgot password page
     *
     * @return View
     */
    public function index()
    {
        return view('frontend.auth.forgot-password');
    }

    /**
     * Send otp to user email
     *
     * @param VerifyEmailRequest $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(VerifyEmailRequest $request)
    {
        try {
            $user = $this->userRepository->forgotPassword($request);
            if (!empty($user)) {
                $token = Crypt::encryptString($user->id);
                $redirectUrl = route('frontend/forgot-password/verify-otp', ['token' => $token]);
                return $this->apiSuccessResponse(['redirectUrl' => $redirectUrl], trans('message.otp_sent'));
            }
            return $this->apiErrorResponse(trans('message.something_went_wrong'), 400);
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }

    /**
     * Show verfy otp form
     * @param  \Illuminate\Http\Request  $request
     * @return View
     */
    public function verifyOtpForm(Request $request)
    {
        $userId = Crypt::decryptString($request->token);
        $user = $this->userRepository->findUser($userId);

        return view('frontend.auth.verify-otp', ['user' => $user, 'token' => $request->token, 'type' => 'forgot_password']);
    }

    /**
     * Show create password form
     * @param  \Illuminate\Http\Request  $request
     * @return View
     */
    public function createPasswordForm(Request $request)
    {
        $userId = Crypt::decryptString($request->token);
        $user = $this->userRepository->findUser($userId);
        return view('frontend.auth.create-password', ['user' => $user, 'token' => $request->token]);
    }

    /**
     * Set new password
     * @param  \Illuminate\Http\CreatePasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function createPassword(CreatePasswordRequest $request)
    {
        try {
            $post = $request->all();
            $userId = Crypt::decryptString($request->token);
            $user = $this->userRepository->findUser($userId);
            if (!empty($user) && ($user->id == session('userId')) && (session('otpVerified'))) {

                $data['new_password'] = $post['new_password'];
                $data['otp'] = $user->otp;
                $user = $this->userRepository->resetPassword($data);

                session()->forget('userId');
                session()->forget('otpVerified');

                return $this->apiSuccessResponse([], trans('message.reset_password'));
            }
            return $this->apiErrorResponse(trans('message.something_went_wrong'));
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage());
        }
    }
}
