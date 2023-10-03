<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CategoryRepository;
use App\Repositories\ClassRepository;
use App\Repositories\UserRepository;
use App\Models\ClassWebinar;
use App\Models\RatingReview;
use App\Http\Resources\V1\UserResource;


/**
 * Class for student dashboard opration
 */
class DashboardController extends Controller
{

    protected $categoryRepository;
    protected $classRepository;
    
    /**
     * Method __construct
     * 
     * @param CategoryRepository $categoryRepository  
     * @param ClassRepository    $classRepository     
     * @param UserRepository     $userRepository       
     *
     * @return void
     */

    public function __construct(
        CategoryRepository $categoryRepository,
        ClassRepository $classRepository,
        UserRepository $userRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->classRepository = $classRepository;
        $this->userRepository = $userRepository;
    }


    /**
     * Class is created for student dashboard oprations.
     * 
     * @return View
     */
    public function index()
    {
        $categories = $this->categoryRepository->getLevels();
        $params['size'] = config('repository.pagination.slider_limit');
        $params['status'] = ClassWebinar::STATUS_ACTIVE;
        $params['class_type'] = ClassWebinar::TYPE_CLASS;
        $classes = $this->classRepository->getClasses($params);

        $params['class_type'] = ClassWebinar::TYPE_WEBINAR;

        $webinars = $this->classRepository->getClasses($params);
        $tutors = $this->userRepository->getFeaturedTutors($params);
        $tutors->map(
            function ($item, $key) {
                $item->total_classes = ClassWebinar::classCount(
                    $item->id,
                    ClassWebinar::TYPE_CLASS,
                    true
                );

                $item->total_webinars = ClassWebinar::classCount(
                    $item->id,
                    ClassWebinar::TYPE_WEBINAR,
                    true
                );
                $item->rating = RatingReview::getAverageRating(
                    $item->id
                );
                return $item;
            }
        );
        return view(
            'frontend/student/dashboard',
            compact(
                'categories',
                'classes',
                'webinars',
                'tutors'
            )
        );
    }

}
