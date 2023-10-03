<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\UploadProfileRequest;

/**
 * ProfileController Class
 */
class ProfileController extends Controller
{
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
        $this->userRepository = $userRepository;
    }

    /**
     * Function editProfile
     *
     * @return View
     */
    public function editProfile()
    {
         $id = Auth::guard('web')->user()->id;
        $admin = $this->userRepository->findUser($id);
        return view('admin.profile.profile', compact('admin'));
    }

    /**
     * Function updateProfile
     *
     * @param UpdateAdminProfileRequest $request [explicite description]
     * 
     * @return void
     */
    public function updateProfile(UpdateAdminProfileRequest $request)
    {
        try {
            $id = Auth::guard('web')->user()->id;
            $user = $this->userRepository->update($request->all(), $id);
            if (!empty($user)) {
                return response()->json(
                    ['success' => true, 'message' => trans('message.update_profile')]
                );
            }
            return response()->json(
                ['success' => false, 'message' => trans('message.something_went_wrong')]
            );
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Function uploadProfile
     *
     * @param UploadProfileRequest $request [explicite description]
     * 
     * @return void
     */
    public function uploadProfile(UploadProfileRequest $request)
    {
        try {
            $id = Auth::guard('web')->user()->id;
            $post = $request->all();
            $upload = $this->userRepository->updateUser($post, $id, false);
            if (!empty($upload)) {
                return response()->json(['success' => true, 'message' => trans('message.upload_profile')]);
            }
            return response()->json(
                ['success' => false, 'message' => trans('message.something_went_wrong')]
            );
        } catch (Exception $ex) {
            return response()->json(['success' => false, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Function changePassword
     *
     * @param ChangePasswordRequest $request [explicite description]
     * 
     * @return void
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $post = $request->all();
            $id = Auth::guard('web')->user()->id;
            $array = array('password' => bcrypt($post['new_password']));
            $changePassword = $this->userRepository->update($array, $id);
            if (!empty($changePassword)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.changed_password')
                    ]
                );
            }
            return response()->json(
                ['success' => false, 'message' =>
                trans('admin.something_went_wrong')]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }
}
