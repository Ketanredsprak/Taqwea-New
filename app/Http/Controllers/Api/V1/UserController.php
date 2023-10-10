<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CompleteProfileRequest;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Repositories\SupportRequestRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userRepository;

    protected $supportRequestRepository;
    
    /**
     * Method __construct
     *
     * @param UserRepository $userRepository [explicite description]
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        SupportRequestRepository $supportRequestRepository
    ) {
        $this->userRepository = $userRepository;
        $this->supportRequestRepository = $supportRequestRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResource
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return UserResource
     */
    public function show($id)
    {
        try {
            $user = $this->userRepository->findUser($id);
            return new UserResource($user);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProfileRequest $request
     * @param int                  $id
     *
     * @return JsonResource
     */
    public function update(UpdateProfileRequest $request, $id)
    {
        $data = $request->all();
        try {
            $user = $this->userRepository->updateUser($data, $id);
            return new UserResource($user);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->userRepository->deleteUser($id);
            return $this->apiDeleteResponse();
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Complete user profile
     *
     * @param CompleteProfileRequest $request
     * @param int                    $id
     *
     * @return JsonResource
     */
    public function completeProfile(CompleteProfileRequest $request, $id)
    {
        $data = $request->all();
        try {
            $user = $this->userRepository->completeProfile($data, $id);
            return new UserResource($user);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Complete user profile
     *
     * @param Request $request
     * @param User    $user
     *
     * @return JsonResource
     */
    public function supportRequest(Request $request, User $user)
    {
        $data = $request->all();
        try {
            $data['name'] = $user->name;
            $data['email'] = $user->email;
            $this->supportRequestRepository->addSupportRequest($data);
            return $this->apiSuccessResponse();
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }
    
    /**
     * Set user language
     *
     * @param \Illuminate\Http\Request $request [explicite description]
     *
     * @return \Illuminate\Http\Response
     */
    public function setLanguage(Request $request)
    {
        try {
            if (Auth::check()) {
                $data['language'] = $request->header('language');
                $this->userRepository->changeUserStaus($data, Auth::user()->id);
            }
            return $this->apiSuccessResponse([], trans('message.language_changed'));
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }


     /**
     * Set is availble status
     *
     * @param \Illuminate\Http\Request $request [explicite description]
     *
     * @return \Illuminate\Http\Response
     */
    public function changeIsAvailbleStatus()
    {
        try {
            if (Auth::check()) {
                 $this->userRepository->changeUserStaus();
            }
            return $this->apiSuccessResponse([], trans('message.notification_status_updated'));
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }





    

}
