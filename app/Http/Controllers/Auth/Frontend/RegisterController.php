<?php

namespace App\Http\Controllers\Auth\Frontend;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Requests\Auth\CompleteSignupRequest;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Http\Response;

class RegisterController extends Controller
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
     *
     * @return View
     */
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
            return redirect('/tutor/dashboard');
        }
        if (Auth::check() && Auth::user()->user_type == User::TYPE_STUDENT) {
            return redirect('/');
        }

        $referralCode = $request->referral_code;
        return view(
            'frontend.auth.sign-up',
            compact('referralCode')
        );
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SignupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SignupRequest $request)
    {
        try {
            $post = $request->all();
            $post['status'] = 'active';
            $post['user_type'] = $request->user_role;

            $redirectUrl = '';
            $sendOtp = '';
            if ($request->user_role === User::TYPE_STUDENT) {
                $redirectUrl = route('student/dashboard');
                $sendOtp = false;
            } else {
                $post['is_verified'] = 0;
                $post['is_profile_completed'] = 0;
                $sendOtp = true;
            }
            $post['approval_status'] = isset($post['user_type']) && 
            $post['user_type'] == User::TYPE_STUDENT ? 
                User::APPROVAL_STATUS_APPROVED : 
                User::APPROVAL_STATUS_PENDING;
            $user = $this->userRepository->createUser($post, $sendOtp);
            if ($request->user_role === User::TYPE_TUTOR) {
                $token = Crypt::encryptString($user->id);
                $redirectUrl = route('verify-otp', ['token' => $token]);
            } else {
                // Auto login student
                $credentials['email'] = $request->email;
                $credentials['password'] = $request->password;
                Auth::attempt($credentials);
                if (Auth::check()) {
                    $data['language'] = config('app.locale');
                    $this->userRepository->updateUser($data, Auth::user()->id);
                }
               
            }

            return $this->apiSuccessResponse(['redirectUrl' => $redirectUrl], trans('message.register'));
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

    /**
     * Complete sign up If user login from social media
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function completeSignUpForm(Request $request)
    {
        $id = Crypt::decryptString($request->token);
        $user = $this->userRepository->findUser($id);
        return view('frontend.auth.complete-sign-up', ['user' => $user]);
    }

    /**
     * Complete sign up If user login from social media
     * 
     * @param CompleteSignupRequest $request 
     * 
     * @return Response
     */
    public function completeSignUp(CompleteSignupRequest $request)
    {
        try {
            $user = $this->userRepository->findUser($request->id);
            $post = $request->all();
            $post['user_type'] = $post['user_role'];
            $post['approval_status'] = isset($post['user_type']) && 
            $post['user_type'] == User::TYPE_STUDENT ? 
                User::APPROVAL_STATUS_APPROVED : 
                User::APPROVAL_STATUS_PENDING;
            $this->userRepository->updateUser($post, $user->id);
            Auth::login($user);
            if ($request->user_role === User::TYPE_STUDENT) {
                $redirectUrl = route('student/dashboard');
            } else if ($request->user_role === User::TYPE_TUTOR) {
                $redirectUrl = route('tutor/complete/registration');
            } else {
                $redirectUrl = route('home');
            }
            return $this->apiSuccessResponse(['redirectUrl' => $redirectUrl], trans('message.register'));
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }
}
