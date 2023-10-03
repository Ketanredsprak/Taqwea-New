<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClassWebinar;
use App\Models\RatingReview;
use App\Models\Blog;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GradeRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\RatingReviewRepository;
use App\Repositories\BlogRepository;
use Exception;

/**
 * Class is created for guest tutors 
 */
class TutorController extends Controller
{
    protected $userRepository;
    protected $categoryRepository;
    protected $gradeRepository;
    protected $ratingReviewRepository;
    protected $blogRepository;

    /**
     * Method __construct
     *    
     * @param UserRepository         $userRepository     
     * @param CategoryRepository     $categoryRepository 
     * @param GradeRepository        $gradeRepository    
     * @param SubjectRepository      $subjectRepository            
     * @param RatingReviewRepository $ratingReviewRepository            
     * @param BlogRepository         $blogRepository            
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        GradeRepository $gradeRepository,
        SubjectRepository $subjectRepository,
        RatingReviewRepository $ratingReviewRepository,
        BlogRepository $blogRepository
    ) {
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->gradeRepository = $gradeRepository;
        $this->subjectRepository = $subjectRepository;
        $this->ratingReviewRepository = $ratingReviewRepository;
        $this->blogRepository = $blogRepository;
    }
    
    /**
     * Show tutors
     * 
     * @return View 
     */
    public function index()
    {
        $data['education'] = $this->categoryRepository->getByHandle('education');
        $data['generalKnowledge'] = $this->categoryRepository
            ->getByHandle('general-knowledge');
        $data['language'] = $this->categoryRepository->getByHandle('language');
        $data['grades'] = $this->gradeRepository->getAll();
        $data['subjects'] = $this->subjectRepository->getAll();
        return view('frontend.featured-tutor.index', $data);
    }

    /**
     * Get list of blogs
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        try {
            $params = $request->all();
            if ($request->level) {
                $params['level'] = explode(',', $request->level);
            }
            if ($request->grade) {
                $params['grade'] = explode(',', $request->grade);
            }
            if ($request->subject) {
                $params['subject'] = explode(',', $request->subject);
            }
            if ($request->generalknowledge) {
                $params['generalknowledge'] = explode(',', $request->generalknowledge);
            }
            if ($request->language) {
                $params['language'] = explode(',', $request->language);
            }
            if ($request->experience) {
                $experience = explode(',', $request->experience);
                $params['min_experience'] = $experience[0];
                if (isset($experience[1]) && $experience[1]>0) {
                    $params['max_experience'] = $experience[1];
                }
            }

            $tutors = $this->userRepository->getFeaturedTutors($params);
            $tutors->map(
                function ($item) {
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

                    $item->total_blogs = Blog::blogCount(
                        $item->id
                    );

                    $item->rating = RatingReview::getAverageRating(
                        $item->id
                    );
                    return $item;
                }
            );

            $html = view(
                'frontend.featured-tutor.list', 
                ['tutors' => $tutors]
            )->render();

            return $this->apiSuccessResponse($html, trans('message.class_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request [explicite description] 
     * 
     * @return View
     */
    public function show(Request $request)
    {
        try {
            $user = $this->userRepository->findUser($request->tutor);
            if (!$user) {
                abort(404);
            }
            $user->total_classes = ClassWebinar::classCount(
                $user->id,
                ClassWebinar::TYPE_CLASS,
                true
            );

            $user->total_webinars = ClassWebinar::classCount(
                $user->id,
                ClassWebinar::TYPE_WEBINAR,
                true
            );

            $user->total_blogs = Blog::blogCount(
                $user->id
            );

            $user->rating = RatingReview::getAverageRating(
                $user->id
            );
            $data['user'] = $user;
            $params['orderBy'] = 'DESC';
            $params['to_id'] = $user->id;
            $params['limit'] = 15;
            $params['groupBy'] = true;
            $data['ratingReviews'] = $this->ratingReviewRepository
                ->getRatings($params);

            $blogParams['tutor_id'] = $user->id;
            $data['blogs'] = $this->blogRepository->getBlogs($blogParams);
            
            return view('frontend.featured-tutor.show', $data);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}
