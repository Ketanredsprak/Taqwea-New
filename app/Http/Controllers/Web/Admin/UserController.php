<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Exception;
use App\Http\Requests\Admin\UserChangePasswordRequest;

/**
 * UserController Controller
 */
class UserController extends Controller
{
    protected $userRepository;

    /**
     * Method __construct
     * 
     * @param UserRepository $userRepository 
     * 
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Method changePassword
     * 
     * @param UserChangePasswordRequest $request 
     * 
     * @return void
     */
    public function changePassword(UserChangePasswordRequest $request)
    {
        try {
            $post = $request->all();
            $result = $this->userRepository->changePassword($post);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.changed_password')
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Function UpdateStatus
     *
     * @param Request $request [explicite description]
     * 
     * @return void
     */
    public function changeStatus(Request $request)
    {
        try {
            $data = $this->userRepository->update(
                ['status' => $request->status],
                $request->id
            );
            if (!empty($data)) {
                return response()->json(
                    ['success' => true, 'message' => trans('message.update_status')]
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }
}
