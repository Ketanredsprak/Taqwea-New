<?php

namespace App\Http\Controllers\Web\Tutor;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\UserResource;
use App\Repositories\UserRepository;
use App\Http\Requests\Tutor\PersonalDetailRequest;
use App\Http\Requests\Tutor\ProfessionalDetailRequest;
use App\Models\User;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Crypt;
use Exception;
use App\Mail\TutorCompletedWaitingApprove;

/**
 * Class for tutor complete profile opration
 */
class CompleteProfileController extends Controller
{
    protected $userRepository;
    protected $categoryRepository;

    /**
     * Method __construct
     *
     * @param UserRepository     $userRepository     [explicite description]
     * @param CategoryRepository $categoryRepository [explicite description]
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Show complete profile form
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return View
     */
    public function index(Request $request)
    {
        $data['user'] = Auth::user();
        $data['education'] = $this->categoryRepository->getByHandle('education');
        $data['generalKnowledge'] = $this->categoryRepository->getByHandle('general-knowledge');
        $data['language'] = $this->categoryRepository->getByHandle('language');
        return view('frontend.tutor.complete-profile.index', $data);
    }

    /**
     * Get profile details
     * 
     * @param Request $request [explicite description]
     * 
     * @return UserResource
     */
    public function getDetails(Request $request)
    {
        try {
            $id = Auth::user()->id;

            if (!empty($request->language)) {
                App::setLocale($request->language);
            }
            $user = $this->userRepository->findUser($id);

            return new UserResource($user);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Complete tutor profile
     *
     * @param PersonalDetailRequest $request 
     * @param int                   $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function completeProfile(PersonalDetailRequest $request, $id)
    {
        $data = $request->all();
        try {
            $user = Auth::user();
            $newEmail = "";
            if (!empty($data['email'])) {
                $newEmail = $data['email'];
                $oldEmail = $user->email;
                unset($data['email']);
            }
            $this->userRepository->completeProfile($data, $id);
            $redirectUrl = '';
            if (!empty($newEmail) && $newEmail != $oldEmail) {
                // Send Otp
                $params['user_id'] = $user->id;
                $params['email'] = $newEmail;
                $this->userRepository->sendOtp($params, 'change-email');
                $token = Crypt::encryptString($newEmail);
                $redirectUrl = route(
                    'tutor.change-email.verifyOtp.form',
                    ['token' => $token]
                );
            }
            return $this->apiSuccessResponse(
                ['redirectUrl' => $redirectUrl],
                trans('message.update_profile')
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Save tutor professional details
     *
     * @param ProfessionalDetailRequest $request 
     * @param int                       $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function saveProfessionalDetail(ProfessionalDetailRequest $request, $id)
    {
        $data = $request->all();
        try {
             
            $user = $this->userRepository->findUser($id);
            // resubmit Profile after rejection
            if ($user->approval_status == User::APPROVAL_STATUS_REJECTED) {
                $data["approval_status"] = User::APPROVAL_STATUS_PENDING;
            }
            $data['levels'] = !empty($data['levels']) ? $data['levels'] : '';
            $data['grades'] = !empty($data['grades']) ? $data['grades'] : '';
            $data['subjects'] = !empty($data['subjects']) ? $data['subjects'] : '';
            $data['general_knowledge'] = !empty($data['general_knowledge'])
                ? $data['general_knowledge'] : '';
            $data['languages'] = !empty($data['languages'])
                ? $data['languages'] : '';

            $result = $this->userRepository->completeProfile($data, $id);
            if(!empty($result->is_profile_completed) == 1 && $result->approval_status == User::APPROVAL_STATUS_PENDING)
            {
                $admin_data = User::where('user_type', User::TYPE_ADMIN)->first();
                $email_data['email'] = $admin_data->email;
                $email_data['admin_name'] = $admin_data->name;
                $email_data['tutor_name'] = $user->name;
                $emailTemplate = new TutorCompletedWaitingApprove($email_data);
                sendMail($email_data['email'], $emailTemplate);

            }
            return $this->apiSuccessResponse([], trans('message.update_profile'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Method send for approval
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendForApproval()
    {
        $data["approval_status"] = User::APPROVAL_STATUS_PENDING;
        $id = Auth::user()->id;
        $this->userRepository->completeProfile($data, $id);
        session()->flash('success', trans('message.send_for_approval'));
        return redirect()->route("tutor.verification-pending");
    }
}
