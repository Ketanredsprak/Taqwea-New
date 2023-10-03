<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactUsRequest;
use App\Repositories\SupportRequestRepository;
use App\Repositories\TestimonialRepository;
use Illuminate\Http\Request;
use Exception;
use App\Models\ClassWebinar;
use App\Models\User;
use App\Models\RatingReview;
use App\Repositories\UserRepository;
use App\Repositories\ClassRepository;
use Illuminate\Support\Facades\Auth;
/**
 * Class for home page opration
 */
class HomeController extends Controller
{
    protected $supportRequestRepository;
    protected $testimonialRepository;
    protected $userRepository;
    protected $classRepository;

    /**
     * Method __construct
     *
     * @param SupportRequestRepository $supportRequestRepository 
     * @param TestimonialRepository    $testimonialRepository 
     * @param UserRepository           $userRepository            
     * @param ClassRepository          $classRepository            
     *
     * @return void
     */
    public function __construct(
        SupportRequestRepository $supportRequestRepository,
        TestimonialRepository $testimonialRepository,
        UserRepository $userRepository,
        ClassRepository $classRepository
    ) {
        $this->supportRequestRepository = $supportRequestRepository;
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
        $this->testimonialRepository = $testimonialRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
                return redirect('/tutor/dashboard');
        }
        
        $params['size'] = config('repository.pagination.slider_limit');
        $tutors = $this->userRepository->getFeaturedTutors($params);
        $testimonials = $this->testimonialRepository->getRecentTestimonial();
        $tutors->map(
            function ($item) {
                $item->total_classes = ClassWebinar::classCount(
                    $item->id,
                    ClassWebinar::TYPE_CLASS
                );

                $item->total_webinars = ClassWebinar::classCount(
                    $item->id,
                    ClassWebinar::TYPE_WEBINAR
                );
                $item->rating = RatingReview::getAverageRating(
                    $item->id
                );
                return $item;
            }
        );
        return view(
            'frontend.home',
            compact('tutors', 'testimonials')
        );
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
            setUserLanguage($request->get('languageCode'));
            if (Auth::check()) {
                $data['language'] = $request->get('languageCode');
                $this->userRepository->updateUser($data, Auth::user()->id);
            }
            return $this->apiSuccessResponse([], trans('message.language_changed'));
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }

    /**
     * Set user current timezone
     * 
     * @param \Illuminate\Http\Request $request  
     * 
     * @return Void
     */
    public function setTimezone(Request $request)
    {
        try {
            $timezone  = $request->header('time-zone');
            $request->session()->put('timezone', $timezone);
            return $this->apiSuccessResponse(['timezone' => $timezone], 'Timezone set successfully');
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }

    /**
     * Method contactUs
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function contactUs(Request $request)
    {
        return view('frontend.contact-us');
    }

    /**
     * Method contactSubmit
     *
     * @param ContactUsRequest $request [explicite description]
     *
     * @return void
     */
    public function contactSubmit(ContactUsRequest $request)
    {
        $data = $request->all();
        try {
            $this->supportRequestRepository->addSupportRequest($data);
            return $this->apiSuccessResponse(
                null,
                trans('message.support_request_sent')
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Method classList
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function classList(Request $request)
    {
        try {
            $params['size'] = config('repository.pagination.slider_limit');
            $params['class_type'] = $request->type;
            $params['class_status'] = 'upcoming';
            $classes = $this->classRepository->getClasses($params);
            $html = view(
                'frontend.class-list',
                [
                    'classes' => $classes,
                ]
            )->render();
            return $this->apiSuccessResponse($html, trans('message.class_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}
