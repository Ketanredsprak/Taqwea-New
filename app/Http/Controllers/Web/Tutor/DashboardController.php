<?php

namespace App\Http\Controllers\Web\Tutor;

use Session;
use Exception;
use DateTimeZone;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\TutorPayout;
use App\Models\ClassWebinar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BlogRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClassRepository;

/**
 * Class for tutor dashboard operation
 */
class DashboardController extends Controller
{
    protected $classRepository;

    protected $userRepository;

    protected $classBookingRepository;

    protected $blogRepository;

    /**
     * Method __construct
     * 
     * @param ClassRepository $classRepository 
     * @param UserRepository  $userRepository 
     * @param BlogRepository  $blogRepository 
     *
     * @return void
     */
    public function __construct(
        ClassRepository $classRepository,
        UserRepository $userRepository,
        BlogRepository $blogRepository
    ) {
        $this->classRepository = $classRepository;
        $this->userRepository = $userRepository;
        $this->blogRepository = $blogRepository;
    }

    /**
     * Class is created for tutor dashboard oprations.
     * 
     * @return View
     */
    public function index()
    {

        $timezone = Session::get('timezone') ?? config('app.timezone');

        $params['size'] = config('repository.pagination.slider_limit');
        $params['tutor_id'] = Auth::user()->id;
        $counts = $this->classRepository->getDashboardCount('', $params);
        $blogs = $this->blogRepository->getDashboardCount($params);
        $users = $this->userRepository->getDashboardCount();
        $counts['students'] = $users['student_count'];
        $totalTutorPayout = TutorPayout::totalPayout($params['tutor_id']);
        $counts['earnings'] = $totalTutorPayout;
        $counts['dues'] = ($users['tutor_earning'] - $totalTutorPayout - Transaction::totalFine($params['tutor_id']));
        $counts['blog_count'] = $blogs['total_blogs'] ?? 0;

        $params['class_type'] = ClassWebinar::TYPE_CLASS;
        $params['class_status'] = 'upcoming';

        $params['userTimezone'] = Carbon::createFromTimestamp(0, $timezone)
            ->getOffsetString();

        $params['schedule_date'] = nowDate("Y-m-d");

        $params['self'] = true;
        $params['status'] = ClassWebinar::STATUS_ACTIVE;
        $classes = $this->classRepository->getClasses($params);
        $params['class_type'] = ClassWebinar::TYPE_WEBINAR;
        $webinars = $this->classRepository->getClasses($params);
       
        return view(
            'frontend/tutor/dashboard',
            [
                "counts" => $counts,
                "classes" => $classes,
                "webinars" => $webinars
            ]
        );
    }

    /**
     * Show verification pending page 
     * 
     * @return View
     */
    public function verificationPendig()
    {
        if (Auth::user()->approval_status == "approved") {
            return redirect('tutor/dashboard');
        }
        
        return view('frontend/tutor/verification-pending');
    }

    /**
     * Show registration complete page 
     * 
     * @return View
     */
    public function registrationComplete()
    {
        return view('frontend/tutor/registration-complete');
    }
}
