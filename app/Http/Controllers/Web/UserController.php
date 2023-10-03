<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassWebinar;
use App\Models\RatingReview;
use App\Models\Blog;
use App\Models\User;
use App\Models\UserDevice;
use App\Repositories\UserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GradeRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\RatingReviewRepository;
use App\Repositories\BlogRepository;
use App\Repositories\UserDeviceRepository;
use Exception;
use Illuminate\Http\Response;

/**
 * Class is created for guest tutors 
 */
class UserController extends Controller
{
    protected $userDeviceRepository;

    /**
     * Method __construct
     *    
     * @param UserDeviceRepository $userDeviceRepository      
     *
     * @return void
     */
    public function __construct(
        UserDeviceRepository $userDeviceRepository
    ) {
        $this->userDeviceRepository = $userDeviceRepository;
    }
    
    /**
     * Update user fcm token.
     *
     * @param User    $user 
     * @param Request $request 
     * 
     * @return Response
     */
    public function updateToken(User $user, Request $request)
    {
        try {
            $post['device_id'] = $request->token;
            $post['device_type'] = UserDevice::TYPE_WEB;
            $post['user_id'] = $user->id;
            $device = $this->userDeviceRepository->createDevice($post);
            return $this->apiSuccessResponse($device);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}
