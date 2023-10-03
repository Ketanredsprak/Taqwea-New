<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\Student\ProfileRequest;
use Exception;
use Illuminate\Support\Facades\App;
use App\Http\Resources\V1\UserResource;

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
        return view('frontend.student.profile.index', $data);
    }

    /**
     * Method update
     * 
     * @param Request $request 
     * @param Int     $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request, $id)
    {
        $data = $request->all();
        try {
            $data['levels'] = !empty($data['levels']) ? $data['levels'] : '';
            $data['grades'] = !empty($data['grades']) ? $data['grades'] : '';
            $data['subjects'] = !empty($data['subjects']) ? $data['subjects'] : '';
            $data['general_knowledge'] = !empty($data['general_knowledge'])
                ? $data['general_knowledge'] : '';
            $data['languages'] = !empty($data['languages'])
                ? $data['languages'] : '';
            $this->userRepository->updateUser($data, $id);
            return $this->apiSuccessResponse([], trans('message.update_profile'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
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
}
