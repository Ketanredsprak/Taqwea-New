<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\ClassRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GradeRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\ThreadRepository;
use App\Repositories\CategorySubjectRepository;
use Illuminate\Http\Request;
use App\Models\ClassWebinar;
use App\Models\User;
use Exception;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Share;
use Illuminate\Support\Facades\URL;

class ClassController extends Controller
{
    protected $classRepository;

    protected $categoryRepository;

    protected $gradeRepository;

    protected $threadRepository;

    protected $subjectRepository;

    protected $transactionRepository;

    protected $categorySubjectRepository;

    /**
     * Method __construct
     *
     * @param ClassRepository           $classRepository
     * @param CategoryRepository        $categoryRepository
     * @param GradeRepository           $gradeRepository
     * @param SubjectRepository         $subjectRepository
     * @param TransactionRepository     $transactionRepository
     * @param ThreadRepository          $threadRepository
     * @param CategorySubjectRepository $categorySubjectRepository
     *
     * @return void
     */
    public function __construct(
        ClassRepository $classRepository,
        CategoryRepository $categoryRepository,
        GradeRepository $gradeRepository,
        SubjectRepository $subjectRepository,
        TransactionRepository $transactionRepository,
        ThreadRepository $threadRepository,
        CategorySubjectRepository $categorySubjectRepository
    ) {
        $this->classRepository = $classRepository;
        $this->categoryRepository = $categoryRepository;
        $this->gradeRepository = $gradeRepository;
        $this->subjectRepository = $subjectRepository;
        $this->transactionRepository = $transactionRepository;
        $this->threadRepository = $threadRepository;
        $this->categorySubjectRepository = $categorySubjectRepository;
    }

    /**
     *  Show webinars
     *
     * @return View
     */
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
            return redirect('/tutor/dashboard');
        }
        $data['id'] = $request->id;
        $data['maxPrice'] = $this->classRepository->getMaxPrice(['class_type' => 'class']);
        $data['education'] = $this->categoryRepository->getByHandle('education');
        $data['grades'] = $this->gradeRepository->getAll();
        $data['subjects'] = $this->subjectRepository->getAll();
        $data['category_subjects'] = $this->categorySubjectRepository
            ->getUniqueSubjects($request->all(), false);
        $data['generalKnowledge'] = $this->categoryRepository
            ->getByHandle('general-knowledge');
        $data['language'] = $this->categoryRepository->getByHandle('language');
        $data['class_type'] = 'class';
        $data['title'] = __('labels.classes_list');
        return view('frontend.class.index', $data);
    }

    /**
     * Get list of webinar
     *
     * @param \Illuminate\Http\Request $request [explicite description]
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        try {
            $params = $request->all();
            $params['status'] = 'active';
            $params['class_type'] = $request->class_type;
            $params['sortColumn'] = 'total_fees';
            $params['sortDirection'] = $request->order_by;

            if ($request->price) {
                $price = explode(',', $request->price);
                $params['min_price'] = $price[0];
                $params['max_price'] = $price[1];
            }
            if ($request->gender) {
                $params['gender'] = $request->gender;
            }
            if ($request->level) {
                $params['level'] = explode(',', $request->level);
            }
            if ($request->grade) {
                $params['grade'] = explode(',', $request->grade);
            }
            if ($request->subject) {
                $params['subject'] = explode(',', $request->subject);
            }
            if ($request->gk_level) {
                $params['gk_level'] = explode(',', $request->gk_level);
            }
            if ($request->language_level) {
                $params['language_level'] = explode(',', $request->language_level);
            }

            $classes = $this->classRepository->getClasses($params);
            $html = view('frontend.class.class-list', ['classes' => $classes])->render();
            return $this->apiSuccessResponse($html, trans('message.faq_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     *
     * @return View
     */
    public function show(Request $request)
    {


        try {
            $class = $this->classRepository->getClass($request->class);
            if (!$class) {
                abort(404);
            }

            $params["class_id"] = $class->id;
            $isChat = $this->threadRepository->getThread($params);
            $class->is_booking = $this->checkBookingItems(
                [
                    'item_id' => $class->id,
                    'item_type' => 'class'
                ]
            );
            $lang = request()->get('lang') ?? config('app.locale');
            App::setLocale($lang);
            $url = URL::route('classes/show', ['class' => $class->slug]);
            $typeLabel = __('labels.class');
            if ($class->class_type == ClassWebinar::TYPE_WEBINAR) {
                $typeLabel = __('labels.webinar');
            }
            $shareLinks = getShareLinks($url, __('message.share_message_text', ['type' => $typeLabel]));

            return view(
                'frontend.class.show',
                [
                    'class' => $class,
                    'isChat' => $isChat,
                    'type' => ClassWebinar::TYPE_CLASS,
                    'isBooked' => checkClassBlogBooked($class->id, 'class'),
                    'shareLinks' => $shareLinks,
                    'url' =>  $url,
                    'typeLabel' => $typeLabel,
                ]
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method index
     *
     * @return View
     */
    public function classSchedule(Request $request)
    {
        $params = $request->all();
        $timezone = Session::get('timezone') ?? config('app.timezone');

        $params['userTimezone'] = Carbon::createFromTimestamp(0, $timezone)
            ->getOffsetString();

        $now = Carbon::now();
        $startDate = $now->format('Y-m-d');
        $monthEndDate = $now->addDay(30)->format('Y-m-d');
        $params['start_time'] = $startDate;
        $params['end_time'] = $monthEndDate;
        $params['status'] = ClassWebinar::STATUS_ACTIVE;
        if (!empty($params['tutor'])) {
            $params['tutor_id'] = decrypt($params['tutor']);
        }
        $params["group_by_start_date"] = true;
        $classes =  $this->classRepository
            ->getClasses($params);
        $availableDates = [];
        foreach ($classes as $class) {
            $date = convertDateToTz($class->start_time, 'UTC', 'Y-m-d');
            array_push($availableDates, ['start' => $date]);
        }
        $params['availableDate'] = $availableDates;
        return view('frontend.class.schedule', $params);
    }

    /**
     * Method classScheduleList
     *
     * @param Request $request
     *
     * @return Json
     */
    public function scheduleList(Request $request)
    {
        try {

            $timezone = Session::get('timezone') ?? config('app.timezone');

            $params = $request->all();

            $params['userTimezone'] = Carbon::createFromTimestamp(0, $timezone)
                ->getOffsetString();

            $params['schedule_date'] = nowDate("Y-m-d");

            if (!empty($params['date'])) {
                $params['schedule_date'] = $params['date'];
            }

            if (!empty($params['tutor'])) {
                $params['tutor_id'] = decrypt($params['tutor']);
            }
            $params['status'] = ClassWebinar::STATUS_ACTIVE;

            $params['classes'] = $this->classRepository->getClasses($params);
            $html = view(
                'frontend.class.scheduler-list',
                $params
            )->render();


            return $this->apiSuccessResponse($html, trans('message.class_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method checkBookingItems
     *
     * @param $data
     *
     * @return Bool
     */
    public function checkBookingItems($data)
    {
        try {
            if (!Auth::check()) {
                return true;
            }
            $this->transactionRepository->checkBookingItems($data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
