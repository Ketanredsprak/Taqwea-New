<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tutor\AddClassRequest;
use App\Http\Requests\Tutor\AddClassDetailRequest;
use App\Http\Resources\V1\ClassResource;
use App\Http\Resources\V1\RaiseHandResource;
use App\Repositories\CategoryRepository;
use App\Repositories\ClassRepository;
use App\Models\ClassWebinar;
use App\Models\RaiseHand;
use App\Repositories\ExtraHourRequestRepository;
use App\Repositories\RaiseHandRepository;
use App\Repositories\ThreadRepository;
use App\Repositories\ClassBookingRepository;
use App\Services\AgoraService;
use Carbon\Carbon;
use Codiant\Agora\RtcTokenBuilder;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Share;
use Illuminate\Support\Facades\URL;

class ClassController extends Controller
{
    protected $categoryRepository;

    protected $classRepository;

    protected $raiseHandRepository;

    protected $agoraService;

    protected $extraHourRequestRepository;

    protected $threadRepository;

    protected $classBookingRepository;

    /**
     * Method __construct
     *
     * @param CategoryRepository         $categoryRepository 
     * @param ClassRepository            $classRepository    
     * @param AgoraService               $agoraService       
     * @param RaiseHandRepository        $raiseHandRepository     
     * @param ExtraHourRequestRepository $extraHourRequestRepository      
     * @param threadRepository           $threadRepository      
     * @param ClassBookingRepository     $classBookingRepository 
     *
     * @return void
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        ClassRepository $classRepository,
        AgoraService $agoraService,
        RaiseHandRepository $raiseHandRepository,
        ExtraHourRequestRepository $extraHourRequestRepository,
        ThreadRepository $threadRepository,
        ClassBookingRepository $classBookingRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->classRepository = $classRepository;
        $this->agoraService = $agoraService;
        $this->raiseHandRepository = $raiseHandRepository;
        $this->extraHourRequestRepository = $extraHourRequestRepository;
        $this->threadRepository = $threadRepository;
        $this->classBookingRepository = $classBookingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params['currentPage'] = 'myClasses';
        $params['classType'] = 'class';
        $params['title'] = trans('labels.my_classes');
        return view('frontend.tutor.class.index', $params);
    }

    /**
     * Get list of blogs
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return BlogResource
     */
    public function list(Request $request)
    {
        try {
            $data = [];
            if ($request->type == 'upcoming') {
                $data['class_status'] = 'upcoming';
            } else if ($request->type == 'past') {
                $data['class_status'] = 'past';
            }
            $data['class_type'] = $request->class_type;
            $classes = $this->classRepository->getClasses($data);

            $html = view('frontend.tutor.class.class-list', ['classes' => $classes, 'type' => $request->type])->render();
            return $this->apiSuccessResponse($html, trans('message.class_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = $this->categoryRepository->getParentCategories();
        $data['title'] = trans('labels.add_class');
        $data['classType'] = 'class';
        return view('frontend.tutor.class.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddClassRequest $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(AddClassRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            if (empty(@$data['ar']['class_name'])) {
                unset($data['ar']);
            }
            if (!empty($data['class_id']) && ($data['class_id'] > 0)) {
                $class = $this->classRepository->updateClass($data, $data['class_id']);
            } else {
                $class = $this->classRepository->createClass($data);
            }
            DB::commit();
            return $this->apiSuccessResponse($class, trans('message.class_created'));
        } catch (Exception $e) {
            DB::rollback();
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Store class details
     *
     * @param AddClassDetailRequest $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function addClassDetail(AddClassDetailRequest $request)
    {
        try {
            $data = $request->all();
            $timezone = $request->header('time-zone');
            $classStartTime = str_replace('/', '-', $data['class_date']) . ' ' . $data['class_time'];
            $classStartTime = changeDateToFormat($classStartTime, 'Y-m-d H:i:s');
            $data['duration'] = $data['duration'] * 60;

            $data['start_time'] = convertDateToTz($classStartTime, $timezone, 'Y-m-d H:i:s', 'UTC');
            if ($data['start_time'] < Carbon::now()) {
                throw new Exception(__('message.class_invalid_time'));
            }

            if (@$data['hourly_fees'] > 0) {
                $data['total_fees'] = 0;
            }

            if (@$data['total_fees'] > 0) {
                $data['hourly_fees'] = 0;
            }
            $class = $this->classRepository->updateClass($data, $request->id);
            return $this->apiSuccessResponse($class, trans('message.class_updated'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug 
     * 
     * @return ClassResource
     */
    public function show(string $slug)
    {
        $class = $this->classRepository->getClass($slug);
        if (!$class) {
            abort(404);
        }
        $params["class_id"] = $class->id;
        $isChat = $this->threadRepository->getThread($params);
        $data['class'] = $class;
        $data['is_chat'] = $isChat;
        $data['title'] = trans('labels.class_detail');
        $data['classType'] = 'class';
        $lang = request()->get('lang') ?? config('app.locale');
        App::setLocale($lang);
        $data['shareUrl'] = URL::route('classes/show', ['class' => $class->slug]);
        $typeLabel = __('labels.class');
        if ($class->class_type == ClassWebinar::TYPE_WEBINAR) {
            $typeLabel = __('labels.webinar');
        }
        $data['shareLinks'] = getShareLinks($data['shareUrl'], __('message.share_message_text', ['type' => $typeLabel]));
        $data['typeLabel'] = $typeLabel;
        return view('frontend.tutor.class.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ClassWebinar $class [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassWebinar $class)
    {
        $data['categories'] = $this->categoryRepository->getParentCategories();
        $data['class'] = $class;
        $data['title'] = trans('labels.edit_class');
        $data['classType'] = 'class';
        return view('frontend.tutor.class.create', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ClassWebinar $class 
     * 
     * @return void
     */
    public function destroy(ClassWebinar $class)
    {
        try {
            $this->classRepository->deleteClass($class->id);
            if ($class->class_type == 'class') {
                $mess = trans('message.class_deleted');
            } else {
                $mess = trans('message.webinar_deleted');
            }
            return $this->apiSuccessResponse([], $mess);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Publish Class
     *
     * @param Request      $request 
     * @param ClassWebinar $class 
     * 
     * @return ClassResource
     */
    public function publish(
        Request $request,
        ClassWebinar $class
    ) {
        try {
            $class = $this->classRepository->publishClass($class);

            if ($class->class_type == 'class') {
                $mess = trans('message.class_published');
            } else {
                $mess = trans('message.webinar_published');
            }
            return $this->apiSuccessResponse([], $mess);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method schedule
     * 
     * @param Request $request 
     * 
     * @return view
     */
    public function schedule(Request $request)
    {
        $timezone = Session::get('timezone') ?? config('app.timezone');

        $params['userTimezone'] = Carbon::createFromTimestamp(0, $timezone)
            ->getOffsetString();

        $data["class_type"] = $request->type;
        $data["title"] = trans('labels.my_schedule');
        $data["schedule"] = trans('labels.my_schedule');
        $params['status'] = ClassWebinar::STATUS_ACTIVE;

        $now = Carbon::now();
        $startDate = $now->format('Y-m-d');
        $monthEndDate = $now->addDay(30)->format('Y-m-d');
        $params['start_time'] = $startDate;
        $params['end_time'] = $monthEndDate;
        $params["group_by_start_date"] = true;
        $classes =  $this->classRepository
            ->getClasses($params);
        $availableDates = [];
        foreach ($classes as $class) {
            $date = convertDateToTz($class->start_time, 'UTC', 'Y-m-d');
            array_push($availableDates, ['start' => $date]);
        }
        $data['availableDate'] = $availableDates;
        return view('frontend.tutor.class.schedule', $data);
    }

    /**
     * Method startClass
     *
     * @param string $slug [explicite description]
     *
     * @return void
     */
    public function startClass(string $slug)
    {
        try {
            $class = $this->classRepository->getClass($slug);
            if (!$class) {
                abort(404);
            }
            $this->classRepository->canJoin($class);
            $data['title'] = __('labels.class');
            $data['class'] = $class;
            $data['video_layout'] = true;

            if (!$class->is_started) {
                $classData['is_started'] = 1;
                $this->classRepository->updateClass($classData, $class->id);
            }

            $data['token'] = $this->agoraService->generateToken(
                'channel-' . $class->id,
                $class->tutor_id,
                RtcTokenBuilder::ROLE_PUBLISHER
            );
            $data['whiteBoardToken'] = $this->agoraService->generateWhiteBoardToken(
                'admin'
            );
            $data['raiseHandRequests'] = $this->raiseHandRepository
                ->getRaiseHandRequests(
                    [
                        'class_id' => $class->id
                    ]
                );
            $data['extraHourRequest'] = $this->extraHourRequestRepository
                ->getRequest(
                    [
                        'class_id' => $class->id
                    ]
                );
            return view(
                'frontend.tutor.class.video-call',
                $data
            );
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            $url = route('tutor.classes.index');
            if ($class->class_type == ClassWebinar::TYPE_WEBINAR) {
                $url = route('tutor.webinars.index');
            }
            return redirect($url);
        }
    }

    /**
     *  Method cancel class
     * 
     * @param int $classId 
     * 
     * @return bool
     */
    public function cancelClass($classId)
    {
        try {
            $userId = Auth::user()->id;
            $data = [
                'class_id' => $classId,
                'user_id' => $userId
            ];
            $this->classRepository->cancelClass($data);

            $class = $this->classRepository->getClass((int)$classId);
            if ($class && $class->class_type === 'class') {
                $message = trans('message.class_cancelled');
            } else {
                $message = trans('message.webinar_cancelled');
            }
            return $this->apiSuccessResponse([], $message);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     *  Method end class
     * 
     * @param int $classId 
     * 
     * @return bool
     */
    public function completeClass($classId)
    {
        try {
            $userId = Auth::user()->id;
            $data = [
                'class_id' => $classId,
                'user_id' => $userId
            ];
            $this->classRepository->completeClass($data);
            return $this->apiSuccessResponse([], trans('message.class_completed'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     *  Method updateRaiseHandRequest
     * 
     * @param Request $request 
     * @param int     $id 
     * 
     * @return bool
     */
    public function updateRaiseHandRequest(Request $request, int $id)
    {
        try {
            $data = [
                'status' => $request['status']
            ];
            $raiseHandRequest = $this->raiseHandRepository
                ->updateRaiseHandRequest($id, $data);
            return new RaiseHandResource($raiseHandRequest);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method addExtraHour
     *
     * @param Request      $request [explicite description]
     * @param ClassWebinar $class   [explicite description]
     *
     * @return void
     */
    public function addExtraHour(Request $request, ClassWebinar $class)
    {
        try {
            $data = $request->all();
            $data['extra_duration'] = $data['duration'] * 60;
            $class = $this->classRepository
                ->addExtraHour($class, $data);
            return new ClassResource($class);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method addExtraHour
     *
     * @param Request $request [explicite description]
     * @param int     $id      [explicite description]
     *
     * @return void
     */
    public function updateClassRoomToken(Request $request, int $id)
    {
        try {
            $data = $request->all();
            return $this->classRepository->updateClass($data, $id);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method Student list
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function studentList(int $id)
    {
        try {
            $post['class_id'] = $id;
            $post['confirm'] = 'confirm';
            $bookings = $this->classBookingRepository->getBookings($post);
            if (!empty($bookings)) {
                return view(
                    'frontend.tutor.class.student-list',
                    compact('bookings')
                );
            }
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}
