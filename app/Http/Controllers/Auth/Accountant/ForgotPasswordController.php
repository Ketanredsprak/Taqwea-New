<?php

namespace App\Http\Controllers\Auth\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Repositories\UserRepository;
use App\Http\Requests\Admin\VerifyEmailRequest;
use App\Http\Requests\Admin\ResetPasswordRequest;
use Exception;
use Illuminate\Http\Request;

/**
 * ForgotPasswordController class
 */
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
     * Method showForgotPasswordForm
     *
     * @return View|\Illuminate\Contracts\View\Factory
     */
    public function showForgotPasswordForm()
    {
        return view('accountant.auth.forgot-password');
    }

    /**
     * Function submitForgotPassword
     *
     * @param VerifyEmailRequest $request [explicite description]
     * 
     * @return void
     */
    public function submitForgotPassword(VerifyEmailRequest $request)
    {
        try {
            $user = $this->userRepository->forgotPassword($request);
            $email = $user->email;
            session()->put('email', $email);
            if (!empty($user)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.otp_sent')
                    ]
                );
            }
            return response()->json(
                [
                    'success' => false,
                    'message' => trans('message.something_went_wrong')
                ]
            );
        } catch (Exception $ex) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $ex->getMessage()
                ]
            );
        }
    }

    /**
     * Function resetPassword
     *
     * @return void
     */
    public function resetPassword()
    {
        return view('accountant.auth.reset-password');
    }

    /**
     * Function postResetPassword
     *
     * @param ResetPasswordRequest $request [explicite description]
     * 
     * @return void
     */
    public function postResetPassword(ResetPasswordRequest $request)
    {
        try {
            $user = $this->userRepository->resetPassword($request);
            if (!empty($user)) {
                $message = trans('passwords.reset');
                session()->flash('success', $message);
                return redirect(url('/accountant'));
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Method resendOtp
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function resendOtp(Request $request)
    {
        try {
            $post = $request->all();
            $type = ($post['type']) ? $post['type'] : null;
            $this->userRepository->sendOtp($post, $type);
            return $this->apiSuccessResponse([], trans('message.otp_sent'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }
}
