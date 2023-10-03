<?php

namespace App\Http\Controllers\Auth\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Exception;
use App\Repositories\UserRepository;
use App\Http\Requests\Auth\VerifyOtpRequest;

class VerifyOtpController extends Controller
{
    protected $userRepository;

    /**
     * Method __construct
     *
     * @param UserRepository $userRepository [explicite description]
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = Crypt::decryptString($request->token);
        $user = $this->userRepository->findUser($userId);
        if (!empty($user) && ($user->is_verified)) {
            return redirect()->back();
        }
        return view('frontend.auth.verify-otp', ['user' => $user, 'token' => $request->token, 'type' => 'registration']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VerifyOtpRequest $request)
    {
        try {
            $otp = '';
            if (!empty($request->otp)) {
                foreach ($request->otp as $value) {
                    $otp = $otp.$value;
                }
            }

            $post['otp'] = $otp;
            $post['type'] = $request->type;
            $user = $this->userRepository->verifyOtp($post);
            if ($user) {
                session(['otpVerified' => true, 'userId' => $user->id]);
                if ($request->type == 'registration') {
                    $redirectUrl = route('tutor/complete/registration');
                    // Login user
                    Auth::login($user);
                } elseif ($request->type == 'forgot_password') {
                    $token = Crypt::encryptString($user->id);
                    $redirectUrl = url('forgot-password/create-password', ['token' => $token]);
                } else {
                    $redirectUrl = url('tutor/dashboard');
                }
                return $this->apiSuccessResponse(
                    ['redirectUrl' => $redirectUrl],
                    trans('message.account_verfied')
                );
            }
            return $this->apiErrorResponse(trans('message.something_went_wrong'));
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

    /**
     * Send otp
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(Request $request){
        try {
            $post = $request->all();
            $type = ($post['type']) ? $post['type'] : null;
            $this->userRepository->sendOtp($post, $type);
            return $this->apiSuccessResponse([], trans('message.otp_sent'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}
