<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Student\ChangePasswordRequest;
use App\Repositories\UserRepository;
use Exception;

/**
 * Class is used for tutor change password operation
 */
class ChangePasswordController extends Controller
{

    protected $userRepository;

    /**
     * Method __construct
     *
     * @param UserRepository $userRepository 
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Show change password form
     * 
     * @return View 
     */
    public function index()
    {
        $data['currentPage'] = 'changePassword';
        return view('frontend.student.change-password.index', $data);
    }

    /**
     * Method changePassword
     *
     * @param ChangePasswordRequest $request 
     *
     * @return JsonResponse
     */
    public function update(ChangePasswordRequest $request)
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
}
