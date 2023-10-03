<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\StudentDashboardResource;
use App\Models\ClassWebinar;
use App\Repositories\BlogRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ClassRepository;
use App\Repositories\UserRepository;
use App\Repositories\CartRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    protected $blogRepository;

    protected $classRepository;

    protected $categoryRepository;

    protected $userRepository;

    protected $cartRepository;
    
    /**
     * Method __construct
     * 
     * @param BlogRepository     $blogRepository 
     * @param ClassRepository    $classRepository 
     * @param CategoryRepository $categoryRepository 
     * @param UserRepository     $userRepository 
     * @param CartRepository     $cartRepository 
     *
     * @return void
     */
    public function __construct(
        BlogRepository $blogRepository,
        ClassRepository $classRepository,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository,
        CartRepository $cartRepository
    ) {
        $this->blogRepository = $blogRepository;
        $this->classRepository = $classRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request 
     * 
     * @return void
     */
    public function dashboard(Request $request)
    {
        try {
            $user = Auth::user();
            $params = $request->all();
            $blogs = $this->blogRepository->getBlogs();
            $featuredTutors = $this->userRepository->getFeaturedTutors($params);
            $categories = $this->categoryRepository->getLevels();
            $classes = $this->classRepository->getClasses(
                [
                    'class_type' => ClassWebinar::TYPE_CLASS,
                    'class_status' => 'upcoming',
                    'is_booking_count' => true
                ]
            );
            $webinars = $this->classRepository->getClasses(
                [
                    'class_type' => ClassWebinar::TYPE_WEBINAR,
                    'class_status' => 'upcoming',
                    'is_booking_count' => true
                ]
            );
            $cart = $this->cartRepository->getCart($user->id);
            return new StudentDashboardResource(
                [],
                $categories,
                $featuredTutors,
                $classes,
                $webinars,
                $blogs,
                $cart
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}
