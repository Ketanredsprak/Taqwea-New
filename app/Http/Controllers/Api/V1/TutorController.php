<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use DateTimeZone;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Transaction;
use App\Models\TutorPayout;
use App\Models\ClassWebinar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BlogRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClassRepository;
use App\Repositories\TutorRepository;
use App\Http\Resources\V1\UserResource;
use App\Http\Requests\Api\BankDetailRequest;
use App\Repositories\ClassBookingRepository;
use App\Http\Resources\V1\TutorDashboardResource;

class TutorController extends Controller
{
    protected $classRepository;

    protected $userRepository;

    protected $classBookingRepository;

    protected $tutorRepository;
    
    protected $blogRepository;
    /**
     * Method __construct
     * 
     * @param ClassRepository        $classRepository 
     * @param UserRepository         $userRepository 
     * @param ClassBookingRepository $classBookingRepository 
     * @param TutorRepository        $tutorRepository  
     * @param BlogRepository         $blogRepository 
     *
     * @return void
     */
    public function __construct(
        ClassRepository $classRepository,
        UserRepository $userRepository,
        ClassBookingRepository $classBookingRepository,
        TutorRepository $tutorRepository,
        BlogRepository  $blogRepository 
    ) {
        $this->classRepository = $classRepository;
        $this->userRepository = $userRepository;
        $this->classBookingRepository = $classBookingRepository;
        $this->tutorRepository = $tutorRepository;
        $this->blogRepository = $blogRepository;
    }

    /**
     * Method index
     */
    public function index(Request $request)
    {
        try {
            $data = $request->all();
            if (isset($data['experience'])) {
                $experience = explode(',', $data['experience']);
                $data['min_experience'] = $experience[0];
                if (isset($experience[1]) && $experience[1] > 0) {
                    $data['max_experience'] = $experience[1];
                }
            }
            $data['status'] = User::STATUS_ACTIVE;
            $data['user_type'] = User::TYPE_TUTOR;
            $user = $this->userRepository->getUsers($data);
            
            return  UserResource::collection($user);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
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
            $params = $request->all();
            $timezone = $request->header('timezone') ?? config('app.timezone');

            $params['userTimezone'] = Carbon::createFromTimestamp(0, $timezone)
                ->getOffsetString();

            $userTime = Carbon::now(new DateTimeZone($timezone));
            $userTime = $userTime->setTimezone(config('app.timezone'));

            $params['tutor_id'] = Auth::user()->id;
            $counts = $this->classRepository->getDashboardCount('', $params);
            $blogs = $this->blogRepository->getDashboardCount($params);
            $users = $this->userRepository->getDashboardCount();
            $counts['students'] = $users['student_count'];

            $totalTutorPayout = TutorPayout::totalPayout($params['tutor_id']);
            $counts['earnings'] = $totalTutorPayout;
            $counts['dues'] = ($users['tutor_earning'] - $totalTutorPayout - Transaction::totalFine($params['tutor_id']));
            $counts['blogs'] = $blogs['total_blogs'] ?? 0;

            $params['class_type'] = ClassWebinar::TYPE_CLASS;
            $params['class_status'] = 'upcoming';
            $params['schedule_date'] = $userTime->format('Y-m-d');
            $params['self'] = true;
            $params['status'] = ClassWebinar::STATUS_ACTIVE;

            $classes = $this->classRepository->getClasses($params);

            $params['class_type'] = ClassWebinar::TYPE_WEBINAR;
            $webinars = $this->classRepository->getClasses($params);

            return new TutorDashboardResource(
                [],
                $counts,
                $classes,
                $webinars
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Function store all cards
     * 
     * @param BankDetailRequest $request 
     * 
     * @return void
     */
    public function saveBankDetail(BankDetailRequest $request)
    {
        try {
            $user = Auth::user();
            $post = $request->all();
            $results = $this->tutorRepository->updateTutor($user, $post);
            if (!empty($results)) {
                return $this->apiSuccessResponse([], trans('message.add_bank_details'));
            }
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}
