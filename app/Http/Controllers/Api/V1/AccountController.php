<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Repositories\UserRepository;
use App\Repositories\UserDeviceRepository;
use Exception;
use App\Http\Requests\Api\LoginFormRequest;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\VerificationRequest;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Http\Requests\Api\SocialLoginRequest;
use App\Http\Requests\Api\SignupRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Services\SocialMediaService;
use Illuminate\Http\JsonResponse;
use App\Models\AutoUpdateBasicPlan;

/**
 * AccountController
 */
class AccountController extends Controller
{
    protected $userRepository;

    protected $userDeviceRepository;

    protected $socialMediaService;
    
    /**
     * Method __construct
     *
     * @param UserRepository       $userRepository       [explicite description]
     * @param UserDeviceRepository $userDeviceRepository [explicite description]
     * @param SocialMediaService   $socialMediaService   [explicite description]
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository, 
        UserDeviceRepository $userDeviceRepository,
        SocialMediaService $socialMediaService
    ) {
        $this->userRepository = $userRepository;
        $this->userDeviceRepository = $userDeviceRepository;
        $this->socialMediaService = $socialMediaService;
    }
  
    /**
     * Method userRegistration
     *
     * @param SignupRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function signup(SignupRequest $request)
    {
        try {
            $post = $request->all();
            $sendOtp = true;
            if ($request->user_type === User::TYPE_STUDENT) {
                $sendOtp = false;
            }
            $post['approval_status'] = isset($post['user_type']) && 
            $post['user_type'] == User::TYPE_STUDENT ? 
                User::APPROVAL_STATUS_APPROVED : 
                User::APPROVAL_STATUS_PENDING;
            $user = $this->userRepository->createUser($post, $sendOtp);
            
            $token = JWTAuth::fromUser($user);
            $post['access_token'] = $token;
            $post['user_id'] = $user->id;

            //save or update user device information
            $this->userDeviceRepository->createDevice($post);
            return new UserResource($user);
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

    /**
     * Method socialLogin
     *
     * @param SocialLoginRequest $request [explicite description]
     * @param string             $driver  [explicite description]
     *
     * @return JsonResponse
     */
    public function socialLogin(SocialLoginRequest $request, string $driver)
    {
        try {
            $post = $request->all();
            $userData = $this->socialMediaService
                ->getUserFromToken($driver, $post['token'], $post);
            $userParams = $userData;
            unset($userParams['phone_number']);
            $user = $this->userRepository->getUserByAttribute($userParams);
            
            if ($user) {
                $params['user_id'] = $user->id;
                $social = $this->userRepository->getSocialUser($params);
                if (!$social) {
                    throw new Exception(
                        trans('validation.email_exist')
                    );
                }
            }
            $user = $this->userRepository->createUser($userData, false, true);
            
            $token = JWTAuth::fromUser($user);
            $post['access_token'] = $token;
            $post['user_id'] = $user->id;

            //save or update user device information
            $this->userDeviceRepository->createDevice($post);
            return new UserResource($user);
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

    /**
     * Method login
     *
     * @param LoginFormRequest $request [explicite description]
     *
     * @return JsonResponse|UserResource
     */
    public function login(LoginFormRequest $request)
    {
        $post = $request->all();
                
        if ($request->has("email")) {
            if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $request->email;
            }
        }
        $token = null;
        try {
            $user = $this->userRepository->getUserByAttribute($post);
            $credentials['password'] = $request->password;
            
            if (!$user) {
                return $this->apiErrorResponse(
                    trans('validation.user_not_registered'),
                    400
                );
            }
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->apiErrorResponse(
                    trans('message.invalid_credentials'),
                    400
                );
            }
            
            if ($user->status == User::STATUS_INACTIVE) {
                return $this->apiErrorResponse(
                    trans('message.inactive_account'),
                    422
                );
            }
                       
            $post['access_token'] = $token;
            $post['user_id'] = $user->id;
            
            // Reset force logut
            $data['is_force_logout'] = 0;
            $this->userRepository->updateUser($data, $user->id);

            // Logout other device
            // $userDevice = $this->userDeviceRepository->getDeviceByUser($user->id);
            // foreach ($userDevice as  $device) {
            //     invalidateTokenString($device->access_token);
            // }

            //save or update user device information
            $this->userDeviceRepository->createDevice($post);
            return new UserResource($user);
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }
        
    /**
     * Method logout
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function logout(Request $request) 
    {
        try {
            $userData = $request->user();
            if (!empty($userData)) {
                invalidateToken($request);
            }
            return $this->apiSuccessResponse([], trans('message.user_logout'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }
  
    /**
     * Method forgotPassword
     *
     * @param ForgotPasswordRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request) 
    {
        try {
            $post = $request->all();
            $result = $this->userRepository->forgotPassword($post);
            if ($result) {
                return $this->apiSuccessResponse([], trans('message.otp_sent'));
            } 
            return $this->apiErrorResponse(trans('message.user_not_found'), 422);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }
        
    /**
     * Method sendOtp
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function sendOtp(Request $request) 
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

    /**
     * Method verify
     *
     * @param VerificationRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function verify(VerificationRequest $request) 
    {
        try {
            $post = $request->all();
            $result = $this->userRepository->verifyOtp($post);
            if ($result) {
                return $this->apiSuccessResponse(
                    [],
                    trans('message.account_verfied')
                );
            }
            return $this->apiErrorResponse(trans('message.something_went_wrong'));
        } catch (\Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }
        
    /**
     * Method changePassword
     *
     * @param ChangePasswordRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $post = $request->all();
            $result = $this->userRepository
                ->updateUser(
                    ['password' => bcrypt($post['new_password'])], 
                    $request->user->id,
                    false
                );
            if ($result) {
                return $this->apiSuccessResponse(
                    [],
                    trans('message.changed_password')
                );
            } else {
                return $this->apiErrorResponse(trans('api.something_went_wrong'));
            }
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage());
        }
    }
    
    /**
     * Method resetPassword
     *
     * @param ResetPasswordRequest $request [explicite description]
     *
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $post = $request->all();
            $result = $this->userRepository->resetPassword($post);
            if ($result) {
                return $this->apiSuccessResponse(
                    [],
                    trans('message.reset_password')
                );
            } else {
                return $this->apiErrorResponse(trans('api.something_went_wrong'));
            }
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage());
        }
    }
    
    /**
     * Method getSocialUser
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function getSocialUser(Request $request)
    {
        try {
            $params = $request->all();
            $user = $this->userRepository->getSocialUser($params);
            if (!$user) {
                return $this->apiSuccessResponse();
            }
            return new UserResource($user);
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

}
