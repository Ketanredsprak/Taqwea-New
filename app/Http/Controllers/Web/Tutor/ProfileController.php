<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\Auth\VerifyOtpRequest;
use Exception;

/**
 * Class is create for tutor profile operation 
 */
class ProfileController extends Controller
{

    protected $categoryRepository;
    protected $userRepository;

    /**
     * Method __construct
     *
     * @param CategoryRepository $categoryRepository [explicite description]
     *
     * @return void
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        UserRepository $userRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return View
     */
    public function index(Request $request)
    {
        $data['user'] = Auth::user();
        $data['currentPage'] = 'editProfile';
        $data['education'] = $this->categoryRepository->getByHandle('education');
        $data['generalKnowledge'] = $this->categoryRepository
            ->getByHandle('general-knowledge');
        $data['language'] = $this->categoryRepository->getByHandle('language');
        return view('frontend.tutor.profile.index', $data);
    }

    /**
     * Show form for change email verify otp 
     * 
     * @param \Illuminate\Http\Request $request 
     * 
     * @return View
     */
    public function verifyOtpForm(Request $request)
    {
        $data['token'] = $request->token;
        $data['email'] = Crypt::decryptString($request->token);
        return view('frontend.tutor.profile.verify-otp', $data);
    }

    /**
     * Verify OTP for tutor change password
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(VerifyOtpRequest $request)
    {
        try {
            $user = Auth::user();
            $otp = '';
            if (!empty($request->otp)) {
                foreach ($request->otp as $value) {
                    $otp = $otp . $value;
                }
            }
            $post['otp'] = $otp;
            $post['type'] = $request->type;
            $user = $this->userRepository->verifyOtp($post);
            if ($user) {
                $email = Crypt::decryptString($request->token);
                $data['email'] = $email;
                $this->userRepository->completeProfile($data, $user->id);
                return $this->apiSuccessResponse([], trans('message.email_updated'));
            } else {
                return $this->apiErrorResponse(trans('message.something_went_wrong'));
            }
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }
}
