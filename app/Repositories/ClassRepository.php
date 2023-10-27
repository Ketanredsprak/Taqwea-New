<?php

namespace App\Repositories;

use App\Exceptions\ClassCancelTimeOverException;
use Illuminate\Container\Container as Application;
use App\Jobs\CancelBookingJob;
use App\Events\TutorFineEvent;
use App\Jobs\EndCallJob;
use App\Models\ClassBooking;
use App\Models\Blog;
use App\Models\ClassWebinar;
use App\Models\ExtraHourRequest;
use App\Models\User;
use App\Models\RatingReview;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\AgoraService;
use Exception;
use App\Services\SubscriptionService;
use App\Events\ClassCompletedEvent;

class ClassRepository extends BaseRepository
{
    protected $extraHourRequestRepository;

    protected $subscriptionService;

    protected $tutorRepository;

    protected $agoraService;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClassWebinar::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Method __construct
     *
     * @param Application                $app
     * @param ExtraHourRequestRepository $extraHourRequestRepository
     * @param SubscriptionService        $subscriptionService
     * @param TutorRepository            $tutorRepository
     * @param AgoraService               $agoraService
     *
     * @return void
     */
    public function __construct(
        Application $app,
        ExtraHourRequestRepository $extraHourRequestRepository,
        SubscriptionService $subscriptionService,
        TutorRepository $tutorRepository,
        AgoraService $agoraService
    ) {
        parent::__construct($app);
        $this->extraHourRequestRepository = $extraHourRequestRepository;
        $this->subscriptionService = $subscriptionService;
        $this->tutorRepository = $tutorRepository;
        $this->agoraService = $agoraService;
    }

    /**
     * Method getClasses
     *
     * @param array  $params
     * @param string $paginationType
     *
     * @return Collection
     */
    public function getClasses(array $params = [], $paginationType = 'paginate')
    {
        $sortFields = [
            'id' => 'id',
            'tutor_name' => 'user_translations.name',
            'class_name' => 'class_webinar_translations.class_name',
            'class_description' => 'class_webinar_translations.class_description',
            'duration' => 'duration',
            'hourly_fees' => 'hourly_fees',
            'no_of_attendee' => 'no_of_attendee',
            'start_time' => 'start_time',
            'total_fees' => 'total_fees',
            'category'   => 'category_translations.name',
            'subject'  => 'subject_translations.subject_name',

        ];
        $language = getUserLanguage($params);
        $size = $params['size'] ?? config('repository.pagination.limit');
        /**
         * User
         *
         * @var $loggedInUser User
         **/
        $loggedInUser = Auth::user();
        $query = $this->select(
            'class_webinars.*',
            DB::raw("count(class_webinars.id) as class_count")
        )->leftjoin(
            'class_webinar_translations',
            'class_webinar_translations.class_webinar_id',
            'class_webinars.id'
        )->leftjoin(
            'user_translations',
            'user_translations.user_id',
            'class_webinars.tutor_id'
        )->leftjoin(
            'subject_translations',
            'subject_translations.subject_id',
            'class_webinars.subject_id'
        )->leftjoin(
            'category_translations',
            'category_translations.category_id',
            'class_webinars.category_id'
        );

        if ($language && Auth::check() && $loggedInUser->isAdmin()) {
            $query->whereRaw(
                "if(subject_translations.language IS NOT NULL,
                subject_translations.language= '" . $language . "',
                true )"
            );
            $query->whereRaw(
                "if(user_translations.language IS NOT NULL,
                user_translations.language= '" . $language . "',
                true )"
            );
            $query->whereRaw(
                "if(category_translations.language IS NOT NULL,
                category_translations.language= '" . $language . "',
                true )"
            );
        }

        if (Auth::check() && !$loggedInUser->isAdmin()) {
            if ($loggedInUser->isTutor()) {
                $query->where('class_webinars.tutor_id', $loggedInUser->id);
            }
            $query->withCount(
                [
                    'cartItem' =>
                    function ($q) use ($loggedInUser) {
                        $q->whereHas(
                            'cart',
                            function ($subQuery) use ($loggedInUser) {
                                $subQuery->where('user_id', $loggedInUser->id);
                            }
                        );
                    }
                ]
            );

            $query->with(
                [
                    'bookings' =>
                    function ($q) use ($loggedInUser) {
                        $q->where('student_id', $loggedInUser->id);
                        $q->where('status', ClassBooking::STATUS_CONFIRMED);
                    }
                ]
            );
        }

        $query->withCount(
            [
                'bookings' =>
                function ($q) {
                    $q->whereIn(
                        'status',
                        [
                            ClassBooking::STATUS_CONFIRMED,
                            ClassBooking::STATUS_COMPLETED,
                            ClassBooking::STATUS_CANCELLED
                        ]
                    )
                        ->whereNull('parent_id')
                        ->where(
                            function ($subQuery) {
                                $subQuery->whereRaw(
                                    'class_bookings.cancelled_by
                                    <> class_bookings.student_id'
                                )
                                    ->orWhereNull('cancelled_by');
                            }
                        );
                }
            ]
        );


        if (@$params['min_class_completed'] || @$params['max_class_completed']) {
            $query->where('status', ClassWebinar::STATUS_COMPLETED);
            if (@$params['min_class_completed']) {
                $query->having(
                    'class_completed_count',
                    '>=',
                    $params['min_class_completed']
                );
            }

            if (@$params['max_class_completed']) {
                $query->having(
                    'class_completed_count',
                    '<=',
                    $params['max_class_completed']
                );
            }
        }

        if (!empty($params['class_type'])) {
            $query->where('class_type', $params['class_type']);
        }

        if (!empty($params['search'])) {
            $query->where(
                function ($qry) use ($params) {
                    $qry->whereTranslationLike(
                        'class_name',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'user_translations.name',
                        'like',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'subject_translations.subject_name',
                        'like',
                        "%" . $params['search'] . "%"
                    );
                }
            );
        }

        if (!empty($params['no_of_attendee'])) {
            $query->where('no_of_attendee', $params['no_of_attendee']);
        }

        if (!empty($params['today'])) {
            if (!empty($params['start_time'])) {
                $query->whereDate('end_time', $params['start_time']);
            }
        } else {
            if (!empty($params['start_time'])) {
                $query->whereDate('start_time', '>=', $params['start_time']);
            }

            if (!empty($params['end_time'])) {
                $query->whereDate('start_time', '<=', $params['end_time']);
            }
        }
        if (!empty($params['start_date_time'])) {
            $query->where('start_time', $params['start_date_time']);
        }

        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (!empty($params['tutor_id'])) {
            $query->where('tutor_id', $params['tutor_id']);
        }

        if (!empty($params['class_status'])) {
            if ($params['class_status'] == 'upcoming') {
                if (!(Auth::check() && $loggedInUser->isTutor())) {
                    $query->where('status', ClassWebinar::STATUS_ACTIVE);
                } else {
                    $query->whereIn(
                        'status',
                        [
                            ClassWebinar::STATUS_ACTIVE,
                            ClassWebinar::STATUS_INACTIVE,
                        ]
                    );
                }
            } elseif ($params['class_status'] == 'past') {
                $query->whereIn(
                    'status',
                    [
                        ClassWebinar::STATUS_COMPLETED,
                        ClassWebinar::STATUS_CANCELLED,
                    ]
                );
            }
        }

        if (!empty($params['tutor_name'])) {
            $query->where(
                'user_translations.name',
                'like',
                "%" . $params['tutor_name'] . "%"
            );
        }

        if (!empty($params['is_booked'])) {
            $query->whereHas(
                'bookings',
                function ($subQuery) {
                    $subQuery->whereIn(
                        'status',
                        [
                            ClassBooking::STATUS_CONFIRMED,
                            ClassBooking::STATUS_COMPLETED
                        ]
                    );
                }
            );
        }

        if (@$params['min_price']) {
            $query->where(
                'hourly_fees',
                '>=',
                $params['min_price']
            );
        }

        if (@$params['max_price']) {
            $query->where(
                'hourly_fees',
                '<=',
                $params['max_price']
            );
        }

        if (@$params['gender']) {
            $query->where('gender_preference', $params['gender']);
        }

        if (@$params['level']) {
            $query->where(
                function ($q) use ($params) {
                    if (!is_array($params['level'])) {
                        $params['level'] = [$params['level']];
                    }
                    $q->whereIn('level_id', $params['level']);
                    if (@$params['gk_level']) {
                        if (!is_array($params['gk_level'])) {
                            $params['gk_level'] = [$params['gk_level']];
                        }
                        $q->orWhereIn('level_id', $params['gk_level']);
                    }
                    if (@$params['language_level']) {
                        if (!is_array($params['language_level'])) {
                            $params['language_level'] = [$params['language_level']];
                        }
                        $q->orWhereIn('level_id', $params['language_level']);
                    }
                }
            );
        } else {
            if (@$params['gk_level']) {
                if (!is_array($params['gk_level'])) {
                    $params['gk_level'] = [$params['gk_level']];
                }
                $query->whereIn('level_id', $params['gk_level']);
            }

            if (@$params['language_level']) {
                if (!is_array($params['language_level'])) {
                    $params['language_level'] = [$params['language_level']];
                }
                $query->whereIn('level_id', $params['language_level']);
            }
        }

        if (@$params['grade']) {
            if (!is_array($params['grade'])) {
                $params['grade'] = [$params['grade']];
            }
            $query->whereIn('grade_id', $params['grade']);
        }

        if (@$params['subject']) {
            $query->whereIn('class_webinars.subject_id', $params['subject']);
        }

        if (@$params['category']) {
            $query->whereIn('class_webinars.category_id', $params['category']);
        }

        if (!empty($params['userTimezone'])
            && !empty($params['schedule_date'])
        ) {
            $query->whereRaw(
                "DATE(
                    CONVERT_TZ(
                        start_time, '+00:00', '" . $params['userTimezone'] . "')
                    ) = '" . $params['schedule_date'] . "'"
            );
        }

        if (!empty($params['from_date'])) {
            $query->whereDate('start_time', '>=', Carbon::parse($params['from_date'])->format("Y-m-d"));
        }

        if (!empty($params['to_date'])) {
            $query->whereDate('start_time', '<=', Carbon::parse($params['to_date'])->format("Y-m-d"));
        }

        $sort = $sortFields['start_time'];
        $direction = 'asc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }

        if (!empty($params['order_by_price'])) {
            $query->addSelect(
                DB::raw(
                    '(CASE WHEN total_fees > 0 THEN total_fees
                    ELSE hourly_fees
                    END) AS `total_amount_order_by`'
                )
            );
            $query->orderBy('total_amount_order_by', $params['order_by_price']);
        } else {
            $query->orderBy($sort, $direction);
        }

        // Group by start date
        if (!empty($params['group_by_start_date'])
            && !empty($params['userTimezone'])
            && $params['group_by_start_date']
        ) {
            $query->groupBy(
                DB::raw(
                    "DATE(
                        CONVERT_TZ(
                            `start_time`, '+00:00', '" . $params['userTimezone'] . "'
                        )
                    )"
                )
            );
            $query->where(
                'status',
                '!=',
                ClassWebinar::STATUS_CANCELLED,
            );
        } else {
            $query->groupBy('class_webinars.id');
        }
        //Check class published and active condition
        $query = $this->publishedInactiveCheck($query);

        // filter data by gender
        $query = $this->genderFilter($query);

        if (isset($params['is_paginate'])) {
            return $query->get();
        }

        if ($paginationType == 'paginate') {
            return $query->paginate($size);
        } else {
            return $query->simplePaginate($size);
        }
    }

    /**
     * Method GetClassList
     *
     * @param int   $id
     * @param array $params
     *
     * @return void
     */
    public function getClassList($id, array $params = [])
    {
        $sortFields = [
            'id' => 'id',
            'class_name' => 'class_name',
            'class_type' => 'class_type',
            'class_detail' => 'class_detail',
            'duration' => 'duration',
            'hourly_fees' => 'hourly_fees',
            'total_fees' => 'total_fees',
        ];

        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->where('tutor_id', $id)
            ->select('class_webinars.*')
            ->withTranslation();

        if (!empty($params['search'])) {
            $query->whereTranslationLike(
                'class_name',
                "%" . $params['search'] . "%"
            );
        }

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }
        if (in_array($sort, ['class_name'])) {
            $query->orderByTranslation($sort, $direction);
        } elseif (in_array($sort, ['class_detail'])) {
            $query->orderByTranslation($sort, $direction);
        } else {
            $query->orderBy($sort, $direction);
        }
        //Check class published and active condition
        $query = $this->publishedInactiveCheck($query);

        return $query->paginate($size);
    }

    /**
     * Method getClass
     *
     * @param mixed $id     [explicite description]
     * @param array $params [explicite description]
     *
     * @return ClassWebinar
     */
    public function getClass($id, array $params = [])
    {
        if (is_string($id)) {
            $query = $this->where('slug', $id);
        } else {
            $query = $this->where('id', $id);
        }

        if (Auth::check()) {
            $user = Auth::user();
            $query->with(
                [
                    'cartItem' =>
                    function ($q) use ($user) {
                        $q->whereHas(
                            'cart',
                            function ($subQuery) use ($user) {
                                $subQuery->where('user_id', $user->id);
                            }
                        );
                    }
                ]
            );

            $query->with(
                [
                    'tutor' =>
                    function ($q) {
                        $q->withTrashed();
                    }
                ]
            );

            $query->withCount(
                [
                    'cartItem' =>
                    function ($q) use ($user) {
                        $q->whereHas(
                            'cart',
                            function ($subQuery) use ($user) {
                                $subQuery->where('user_id', $user->id);
                            }
                        );
                    }
                ]
            );

            $query->with(
                [
                    'bookings' =>
                    function ($q) use ($user) {
                        if ($user->isStudent()) {
                            $q->where('student_id', $user->id);
                        }
                        $q->whereIn(
                            'status',
                            [
                                ClassBooking::STATUS_CONFIRMED,
                                ClassBooking::STATUS_COMPLETED,
                                ClassBooking::STATUS_CANCELLED
                            ]
                        )
                            ->whereNull('parent_id')
                            ->where(
                                function ($subQuery) {
                                    $subQuery->whereRaw(
                                        'class_bookings.cancelled_by
                                        <> class_bookings.student_id'
                                    )
                                        ->orWhereNull('cancelled_by');
                                }
                            );
                    }
                ]
            );

            $query->with(
                [
                    'chatThread' =>
                    function ($q) use ($user) {
                        $q->where('student_id', $user->id);
                    }
                ]
            );

            $query->withCount(
                [
                    'rating' =>
                    function ($q) use ($user) {
                        $q->where('from_id', $user->id);
                    }
                ]
            );

            $query->withCount(
                [
                    'raiseDispute' =>
                    function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    }
                ]
            );
        }

        $query->withCount(
            [
                'bookings' =>
                function ($q) {
                    $q->whereIn(
                        'status',
                        [
                            ClassBooking::STATUS_CONFIRMED,
                            ClassBooking::STATUS_COMPLETED,
                            ClassBooking::STATUS_CANCELLED
                        ]
                    )
                        ->whereNull('parent_id')
                        ->where(
                            function ($subQuery) {
                                $subQuery->whereRaw('class_bookings.cancelled_by <> class_bookings.student_id')
                                    ->orWhereNull('cancelled_by');
                            }
                        );
                }
            ]
        );

        //Check class published and active condition
        $query = $this->publishedInactiveCheck($query);
        return $query->first();
    }

    /**
     * Method createClass
     *
     * @param array $data [explicite description]
     *
     * @return ClassWebinar
     */
    public function createClass(array $data): ClassWebinar
    {
       
        try {
            DB::beginTransaction();
            if (!empty($data['class_image'])) {
                $data['class_image'] = uploadFile(
                    $data['class_image'],
                    'class_image'
                );
            }
            $data['tutor_id'] = $data['user']->id;
            if (!empty($data['class_type'])
                && $data['class_type'] == ClassWebinar::TYPE_CLASS
            ) {
                $data['no_of_attendee'] = 5;
            }
            DB::commit();
            return $this->create($data);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

   


    /**
     * Method updateClass
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     *
     * @return ClassWebinar
     */
    public function updateClass(array $data, int $id): ClassWebinar
    {
      
        if (!empty(@$data['start_time'])) {
            $check = $this->checkClassExist(
                $data['start_time'],
                $data['duration'],
                $id
            );
            if (!empty($check)) {
                throw new Exception(__('message.class_already_exist'));
            }
        }
        $class = $this->getClass($id);
        if (!empty($data['class_image'])) {
            $data['class_image'] = uploadFile(
                $data['class_image'],
                'class_image'
            );
            deleteFile($class->profile_image);
        }
        return $this->update($data, $class->id);
    }



    /**
     * Check already exist class
     *
     * @param $startTime [explicite description]
     * @param $duration  [explicite description]
     * @param $classId   [explicite description]
     *
     * @return Void
     */
    public function checkClassExist($startTime, $duration, $classId = '')
    {
        $endTime = Carbon::parse($startTime)->addMinutes($duration);
        $user = Auth::user();

        $query = $this->where("status", '=', ClassWebinar::STATUS_ACTIVE)
            ->where('tutor_id', $user->id);

        $query->checkExists($startTime, $endTime);

        if ($classId != '') {
            $query->where('id', '!=', $classId);
        }

        //Check class published and active condition
        $query = $this->publishedInactiveCheck($query);
        return $query->first();
    }

    /**
     * Method deleteClass
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteClass(int $id): int
    {
        return $this->delete($id);
    }

    /**
     * Method publishClass
     *
     * @param ClassWebinar $class [explicite description]
     *
     * @return ClassWebinar
     */
    public function publishClass(ClassWebinar $class): ClassWebinar
    {
        if (!$this->checkClassCompleted($class)) {
            throw new Exception(trans('error.class_not_completed'));
        }
        if (!empty($class->start_time)) {
            $check = $this->checkClassExist(
                $class->start_time,
                $class->duration,
                $class->id
            );
            if (!empty($check)) {
                throw new Exception(__('message.class_already_exist'));
            }
        }

        $currentTime = currentDateByFormat('Y-m-d H:i:s');
        if ($class->start_time < $currentTime) {
            throw new Exception(
                trans('error.class_time_of_past')
            );
        }

        $roomTokenData = $this->agoraService->generateWhiteboardRoom($class);
        if ($roomTokenData) {
            $data['uuid'] = $roomTokenData['uuid'];
            $data['room_token'] = $roomTokenData['room_token'];
        }
        $this->checkRemainingHours($class->id);
        $data['status'] = ClassWebinar::STATUS_ACTIVE;
        $data["is_published"] = 1;

        return $this->updateClass($data, $class->id);
    }

    /**
     * Method getDashboardCount
     *
     * @param string $for
     * @param array  $params
     *
     * @return mixed
     */
    public function getDashboardCount(
        string $for = '',
        array $params = []
    ) {
        $where = "";
        if ($for == "month") {
            $currentMonth = Carbon::now()->month;
            $where .= " AND MONTH(created_at) = $currentMonth";
        }

        if (!empty($params['tutor_id'])) {
            $where .= " AND tutor_id = " . $params['tutor_id'];
        }
        return $this->select(
            DB::raw(
                "(SELECT COUNT(id)
                    FROM class_webinars
                    WHERE class_type = '" . ClassWebinar::TYPE_CLASS . "'
                    AND status = '" . ClassWebinar::STATUS_COMPLETED . "'
                    $where
                ) AS class_count"
            ),
            DB::raw(
                "(SELECT COUNT(id)
                    FROM class_webinars
                    WHERE class_type = '" . ClassWebinar::TYPE_WEBINAR . "'
                    AND status = '" . ClassWebinar::STATUS_COMPLETED . "'
                    $where
                ) AS webinar_count"
            )
        )->first();
    }

    /**
     * Get blog max price
     *
     * @param Array $where [explicite description]
     *
     * @return Blog
     */
    public function getMaxPrice($where)
    {
        return $this->where($where)->max('total_fees');
    }

    /**
     * Check class available or not for booking
     *
     * @param $id
     *
     * @return ClassWebinar
     */
    public function checkClassAvailable($id)
    {
        /**
         * Check class cancelled
         */
        $checkStatus = $this->where(
            ['status' => ClassWebinar::STATUS_CANCELLED, 'id' => $id]
        )->first();
        if ($checkStatus) {
            throw new Exception(trans('error.class_cancelled'));
        }


        $currentTime = currentDateByFormat('Y-m-d H:i:s');
        $classBookTime = config('services.class_booking_before');
        $endTime = Carbon::parse($currentTime)->addMinutes($classBookTime);
        $class = $this->where(['status' => 'active', 'id' => $id])
            ->where('start_time', '>=', $endTime)
            ->withCount(
                [
                    'bookings' =>
                    function ($q) {
                        $q->where(['status' => 'confirm']);
                    }
                ]
            )
            ->first();
        if (empty($class)) {
            throw new Exception(
                trans(
                    'error.class_booking_time_over',
                    [
                        'hour' => 1
                    ]
                )
            );
        }
        $classMaxStudent = config('services.class_max_student');
        if ($class->class_type == ClassWebinar::TYPE_CLASS
            && @$class->bookings_count >= $classMaxStudent
        ) {
            throw new Exception(trans('error.class_max_limit', ['student' => 5]));
        }
        return $class;
    }

    /**
     * Check class completed
     *
     * @param $class
     *
     * @return Bool
     */
    public function checkClassCompleted($class)
    {
        $res = true;
        if (empty($class->start_time)) {
            $res = false;
        }
        if (empty($class->duration)) {
            $res = false;
        }
        return $res;
    }

    /**
     * Check class cancel
     *
     * @param array $data
     *
     * @return Bool
     */
    public function cancelClass(array $data)
    {
        try {
            DB::beginTransaction();
            $class = $this->where(
                [
                    'id' => $data['class_id'],
                    'tutor_id' => $data['user_id']
                ]
            )->with(
                [
                    "bookings" =>
                    function ($q) {
                        $q->where("status", '=', ClassBooking::STATUS_CONFIRMED);
                    }
                ]
            )
                ->first();

            $currentTime = currentDateByFormat('Y-m-d H:i:s');
            $classCancelTime = config('services.class_cancel_before');
            $currentTime = Carbon::parse($currentTime);
            if (empty($data['is_system'])
                && strtotime($class->start_time) < strtotime($currentTime)
            ) {
                throw new ClassCancelTimeOverException(
                    trans(
                        'error.class_cancel_time_over',
                        [
                            'hour' => getDuration($classCancelTime)
                        ]
                    )
                );
            }

            $class->update(
                [
                    'status' => ClassWebinar::STATUS_CANCELLED
                ]
            );

            if (!empty($data["user_type"])) {
                $user_type = $data["user_type"];
            } else {
                $user_type =  Auth::user()->user_type;
            }
            if ($class) {
                $classBookings = $class->bookings;
                if (count($classBookings) > 0) {
                    foreach ($classBookings as $booking) {
                        if (in_array(
                            $booking->status,
                            [
                                ClassBooking::STATUS_CONFIRMED
                            ]
                        )
                        ) {
                            $data = [
                                'user_id' => $data['user_id'],
                                'booking_id' => $booking->id,
                                'user_type' => $user_type
                            ];
                            CancelBookingJob::dispatch($data);
                        }
                    }
                }
                /* After class/webinar cancelled,
                  add cancel hours in tutor subscription
                 */
                $this->updatePlanClassCancel($class);

                DB::commit();
                return true;
            }
            return false;
        } catch (Exception $e) {
            DB::rollback();
            if ($e instanceof ClassCancelTimeOverException) {
                throw $e;
            }

            throw new Exception(trans('error.server_error'));
        }
    }

    /**
     * Check call end
     *
     * @param array $data
     *
     * @return Bool
     */
    public function completeClass(array $data)
    {
        try {
            DB::beginTransaction();
            $class = $this->where(
                [
                    'id' => $data['class_id'],
                    'tutor_id' => $data['user_id']
                ]
            )->first();

            if ($class) {
                $class->update(
                    [
                        'status' => ClassWebinar::STATUS_COMPLETED
                    ]
                );
                $classBookings = $class->bookings;
                if (count($classBookings) > 0) {
                    foreach ($classBookings as $booking) {
                        if (in_array(
                            $booking->status,
                            [
                                ClassBooking::STATUS_CONFIRMED
                            ]
                        )
                        ) {
                            $data = [
                                'booking_id' => $booking->id
                            ];
                            EndCallJob::dispatch($data);
                            if (!$booking->parent_id) {
                                ClassCompletedEvent::dispatch($data);
                            }
                        }
                    }
                }
                DB::commit();
                return true;
            }
            return false;
        } catch (Exception $e) {
            DB::rollback();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Method canJoin
     *
     * @param ClassWebinar $class [explicite description]
     *
     * @throws Exception
     *
     * @return void
     */
    public function canJoin(ClassWebinar $class)
    {
        $currentTime = Carbon::now();
        if (Auth::check()
            && Auth::user()->user_type == User::TYPE_TUTOR
            && $class->is_live
        ) {
            throw new Exception(__('error.class_already_running'));
        } elseif ($class->start_time > $currentTime) {
            throw new Exception(__('error.class_start_time_is_of_future'));
        } elseif ($class->end_time < $currentTime) {
            throw new Exception(__('error.class_end_time_is_of_past'));
        } elseif ($class->status == ClassWebinar::STATUS_CANCELLED) {
            throw new Exception(__('error.class_cancelled'));
        } elseif ($class->status == ClassWebinar::STATUS_COMPLETED) {
            throw new Exception(__('error.class_completed'));
        }
    }

    /**
     * Method addExtraHour
     *
     * @param ClassWebinar $class [explicite description]
     * @param array        $data  [explicite description]
     *
     * @return void
     */
    public function addExtraHour(ClassWebinar $class, array $data)
    {
        $classExists = $this->checkClassExist(
            $class->end_time,
            $data['extra_duration'],
            $class->id
        );
        if ($classExists) {
            throw new Exception(__('message.class_already_exist'));
        }

        $this->subscriptionService
            ->checkCreation($class->class_type, $data['duration']);
        unset($data['duration']);
        $updated = $this->updateClass($data, $class->id);
        if ($updated && $class->bookings) {
            $this->extraHourRequestRepository->sendRequest($class);
        }
        return $updated;
    }

    /**
     * Method updateEndtime
     *
     * @param ClassWebinar $class [explicite description]
     *
     * @return ClassWebinar
     */
    public function updateEndtime(ClassWebinar $class): ClassWebinar
    {
        $newEndtime = Carbon::parse($class->end_time)
            ->addMinutes($class->extra_duration);
        $params['class_id'] = $class->id;
        $params['status'] = ExtraHourRequest::STATUS_ACCEPTED;
        $extraHourRequest = $this->extraHourRequestRepository->getRequests(
            $params
        );
        if (count($extraHourRequest) <= 1) {
            $data['end_time'] = $newEndtime;
            $class = $this->updateClass($data, $class->id);
        }
        return $class;
    }

    /**
     * Method checkRemainingHours
     *
     * @param int $id
     *
     * @return void
     */
    public function checkRemainingHours($id)
    {
        $user = Auth::user();
        $class = $this->getClass($id);
        $total_duration = ($class->duration) / 60;
        $this->subscriptionService
            ->checkCreation($class->class_type, $total_duration);

        $tutor = $this->tutorRepository->getTutor($user->id);

        if ($class->class_type == ClassWebinar::TYPE_CLASS) {
            $this->tutorRepository->updateTutor(
                $user,
                ["class_hours" => ($tutor->class_hours) - $total_duration]
            );
        }

        if ($class->class_type == ClassWebinar::TYPE_WEBINAR) {
            $this->tutorRepository->updateTutor(
                $user,
                ["webinar_hours" => ($tutor->webinar_hours) - $total_duration]
            );
        }
    }

    /**
     * Method updateTutorPlan
     *
     * @param object $class
     *
     * @return void
     */
    public function updatePlanClassCancel($class)
    {
        $currentTime = currentDateByFormat('Y-m-d H:i:s');
        $classCancelTime = config('services.class_cancel_before');
        $currentDateTime = Carbon::parse($currentTime);
        $endTime = Carbon::parse($currentTime)->addMinutes($classCancelTime);
        $total_duration = ($class->duration) / 60;

        $classBeforOneHrsTime = Carbon::parse($class->start_time)
        ->subMinutes(60);
        // Check if class time is greater then the class end time 
        if (count($class->bookings) != 0
            &&  ( strtotime($currentDateTime) >= strtotime($classBeforOneHrsTime)) 
            && strtotime($class->start_time) > strtotime($endTime)
        ) {
            $fineFees = (($class->hourly_fees != '0.00')) 
            ?  $class->hourly_fees * $total_duration 
            : ($class->total_fees);
            $total_duration = 0;
            // add fine transaction
            $totalBookings = count($class->bookings);
            $fineFees = ($fineFees * 30 / 100) * $totalBookings;
            $fineData = [
                "transaction_id" => getExternalId(),
                "class_id" => $class->id,
                "user_id" => $class->tutor_id,
                "amount" => $fineFees,
                "total_amount" => $fineFees,
                "payment_mode" => Transaction::STATUS_DIRECT_PAYMENT,
                "status" => Transaction::STATUS_SUCCESS,
                "transaction_type" =>  Transaction::STATUS_FINE,
                "response_data" => ''
            ];
            TutorFineEvent::dispatch($fineData);
        } else if (count($class->bookings) != 0
            && strtotime($class->end_time) < strtotime($currentDateTime)
        ) {
            // Check if class end time is greater then the class start time and their was a booking.
            $fineFees = (($class->hourly_fees != '0.00')) 
            ?  $class->hourly_fees * $total_duration 
            : ($class->total_fees);
            $total_duration = 0;
            // add fine transaction
            $totalBookings = count($class->bookings);
            $fineFees = ($fineFees * 30 / 100) * $totalBookings;
            $fineData = [
                "transaction_id" => getExternalId(),
                "class_id" => $class->id,
                "user_id" => $class->tutor_id,
                "amount" => $fineFees,
                "total_amount" => $fineFees,
                "payment_mode" => Transaction::STATUS_DIRECT_PAYMENT,
                "status" => Transaction::STATUS_SUCCESS,
                "transaction_type" =>  Transaction::STATUS_FINE,
                "response_data" => ''
            ];

            TutorFineEvent::dispatch($fineData);

        } else if (( strtotime($currentDateTime) >= strtotime($classBeforOneHrsTime)) 
            && strtotime($class->start_time) > strtotime($endTime)
        ) {
            $total_duration = 0;
        } else {
            $total_duration = ($class->duration) / 60;
        }

        $tutor = $this->tutorRepository->getTutor($class->tutor_id);

        if ($class->class_type == ClassWebinar::TYPE_CLASS) {
            $this->tutorRepository->upgradePlan(
                $class->tutor_id,
                ["class_hours" => ($tutor->class_hours) + $total_duration]
            );
        }

        if ($class->class_type == ClassWebinar::TYPE_WEBINAR) {
            $this->tutorRepository->upgradePlan(
                $class->tutor_id,
                ["webinar_hours" => ($tutor->webinar_hours) + $total_duration]
            );
        }
    }

    /**
     * Method publishedInactiveCheck
     *
     * @param object $query
     *
     * @return Object
     */
    public function publishedInactiveCheck($query)
    {
        /**
         * User
         *
         * @var $loggedInUser User
         **/
        $loggedInUser = Auth::user();
        if (Auth::check() && $loggedInUser->isStudent()) {
            $query->whereIn(
                'status',
                [
                    ClassWebinar::STATUS_ACTIVE,
                    ClassWebinar::STATUS_COMPLETED,
                    ClassWebinar::STATUS_CANCELLED
                ]
            );
            $query->where('is_published', 1);
        } elseif (!Auth::check()) {
            $query->where('status', ClassWebinar::STATUS_ACTIVE);
            $query->where('is_published', 1);
        }
        return $query;
    }

    /**
     * Method globalSearch
     *
     * @param array $params
     *
     * @return Object
     */
    public function globalSearch(array $params = [])
    {
        $language = getUserLanguage($params);
        // For blogs
        $blogs =  Blog::select(
            'blogs.id',
            DB::raw('"blog" as class_type'),
            DB::raw('blog_translations.blog_title as name'),
            DB::raw('media as image_url'),
            "blogs.slug",
            "blogs.type"
        )
            ->leftjoin(
                'blog_translations',
                'blog_translations.blog_id',
                'blogs.id'
            )->where('blog_translations.language', $language)
            ->where(
                'blog_title',
                'like',
                "%" . $params['search'] . "%"
            );

        // For class webinar
        $query = $this->select(
            'class_webinars.id',
            'class_type',
            DB::raw('class_webinar_translations.class_name as name'),
            DB::raw('class_image as image_url'),
            DB::raw('slug as slug'),
            DB::raw('"type" as type')
        )
            ->leftjoin(
                'class_webinar_translations',
                'class_webinar_translations.class_webinar_id',
                'class_webinars.id'
            )
            ->where('class_webinar_translations.language', $language)
            ->where('status', ClassWebinar::STATUS_ACTIVE)
            ->where(
                'class_webinar_translations.class_name',
                "Like",
                "%" . $params['search'] . "%"
            );
        $query = $this->genderFilter($query);

        // For featured tutor
        $tutors = User::select(
            'users.id',
            DB::raw('"featured" as class_type'),
            DB::raw('user_translations.name as name'),
            DB::raw('profile_image as image_url'),
            DB::raw('"slug" as slug'),
            DB::raw('"type" as type')
        )
            ->leftjoin(
                'user_translations',
                'user_translations.user_id',
                'users.id'
            )
            ->leftjoin(
                'tutors',
                'tutors.user_id',
                'users.id'
            )
            ->where('user_translations.language', $language)
            ->where('tutors.is_featured', 1)
            ->where(
                'user_translations.name',
                "Like",
                "%" . $params['search'] . "%"
            );
        return $query->union($blogs)->union($tutors)->limit(10)->get();
    }

    /**
     * Method genderFilter
     *
     * @param object $query
     *
     * @return object
     */
    public function genderFilter($query)
    {
        /**
         * User
         *
         * @var $loggedInUser User
         **/
        $loggedInUser = Auth::user();
        if (Auth::check() && $loggedInUser->isStudent()) {
            if ($loggedInUser->gender == User::MALE) {
                $query->whereIn('gender_preference', ClassWebinar::MALE_CLASSES);
            }
            if ($loggedInUser->gender == User::FEMALE) {
                $query->whereIn('gender_preference', ClassWebinar::FEMALE_CLASSES);
            }
        }
        return $query;
    }

    /**
     * Method search
     *
     * @param array $params
     *
     * @return Object
     */
    public function search(array $params = [])
    {
        $language = getUserLanguage($params);
        // For blogs
        $blogs =  Blog::select(
            'blogs.id',
            'blogs.created_at',
            'tutor_id',
            DB::raw('"blog" as class_type'),
            DB::raw('blog_translations.blog_title as name'),
            DB::raw('media as image_url'),
            "blogs.slug",
            "blogs.total_fees",
            "blogs.type"
        )
            ->with(['tutor'])
            ->leftjoin(
                'blog_translations',
                'blog_translations.blog_id',
                'blogs.id'
            )->where('blog_translations.language', $language)
            ->where(
                'blog_title',
                'like',
                "%" . $params['search'] . "%"
            )
            ->orderBy('blogs.created_at', 'desc');
        $allBlogs = $blogs->get();

        $allBlogs->map(
            function ($blog) {
                $blog->rating = RatingReview::getAverageRating(
                    $blog->tutor_id
                );

                $blog->time = convertDateToTz($blog->created_at, 'UTC', 'd M Y h:i A');
                $blog->amount = number_format($blog->total_fees, 2);
                return $blog;
            }
        );
        // For class webinar
        $query = $this->select(
            'class_webinars.id',
            'class_type',
            'tutor_id',
            'total_fees',
            'duration',
            'hourly_fees',
            'start_time',
            DB::raw('class_webinar_translations.class_name as name'),
            DB::raw('class_image as image_url'),
            DB::raw('slug as slug'),
            DB::raw('"type" as type')
        )
            ->with(['tutor'])
            ->leftjoin(
                'class_webinar_translations',
                'class_webinar_translations.class_webinar_id',
                'class_webinars.id'
            )
            ->where('class_webinar_translations.language', $language)
            ->where('status', ClassWebinar::STATUS_ACTIVE)
            ->where(
                'class_webinar_translations.class_name',
                "Like",
                "%" . $params['search'] . "%"
            );
        $query = $this->genderFilter($query);

        $query->orderBy('start_time', 'asc');
        $classes = $query->get();
        $classes->map(
            function ($class) {
                $class->rating = RatingReview::getAverageRating(
                    $class->tutor_id
                );
                $class->time = convertDateToTz($class->start_time, 'UTC', 'd M Y h:i A');
                $class->amount = (!empty($class->total_fees))?number_format($class->total_fees, 2): number_format(round(($class->duration/60)*$class->hourly_fees, 2), 2);
                return $class;
            }
        );


        // For featured tutor
        $tutors = User::select(
            'users.id',
            DB::raw('"featured" as class_type'),
            DB::raw('user_translations.name as name'),
            DB::raw('profile_image as image_url'),
            DB::raw('tutors.experience as experience'),
            DB::raw('"slug" as slug'),
            DB::raw('"type" as type')
        )
            ->leftjoin(
                'user_translations',
                'user_translations.user_id',
                'users.id'
            )
            ->leftjoin(
                'tutors',
                'tutors.user_id',
                'users.id'
            )
            ->where('user_translations.language', $language)
            ->whereIn('tutors.is_featured', [0, 1])
            ->where(
                'user_translations.name',
                "Like",
                "%" . $params['search'] . "%"
            )
            ->orderBy('user_translations.name', 'asc');
        $allTutors = $tutors->get();

        $allTutors->map(
            function ($user) {
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
                return $user;
            }
        );


        $returnArray['tutors'] = $allTutors;
        $returnArray['classes'] = $classes->where('class_type', 'class');
        $returnArray['webinars'] = $classes->where('class_type', 'webinar');
        $returnArray['blogs'] = $allBlogs;
        return $returnArray;
    }

    /**
     * Check class cancel
     *
     * @param array $data
     *
     * @return Bool
     */
    public function autoCancelClass(array $data)
    {
        try {
            DB::beginTransaction();
            $class = $this->where(
                [
                    'id' => $data['class_id'],
                    'tutor_id' => $data['user_id']
                ]
            )->with(
                [
                    "bookings" =>
                    function ($q) {
                        $q->whereIn(
                            'status', 
                            [
                                ClassBooking::STATUS_CONFIRMED, 
                                ClassBooking::STATUS_COMPLETED
                            ]
                        );
                    }
                ]
            )->first();

            $currentTime = currentDateByFormat('Y-m-d H:i:s');
            $currentTime = Carbon::parse($currentTime);
            $user_type = $data["user_type"];
            // If class has student then mark it cancelled or completed.
            if ($class) {

                $classBookings = $class->bookings;
                if (count($classBookings) > 0) {
                    $class->update(
                        [
                            'status' => ClassWebinar::STATUS_CANCELLED
                        ]
                    );

                    foreach ($classBookings as $booking) {
                        if (in_array(
                            $booking->status,
                            [
                                ClassBooking::STATUS_CONFIRMED,
                                ClassBooking::STATUS_COMPLETED
                            ]
                        )
                        ) {
                            $data = [
                                'user_id' => $data['user_id'],
                                'booking_id' => $booking->id,
                                'user_type' => $user_type
                            ];
                            CancelBookingJob::dispatch($data);
                        }
                    }
                    
                    /* After class/webinar cancelled,
                      add cancel hours in tutor subscription
                     */
                    $this->updatePlanClassCancel($class);

                } else {
                    $class->update(
                        [
                            'status' => ClassWebinar::STATUS_COMPLETED
                        ]
                    );
                }

                DB::commit();
                return true;
            }
            return false;

        } catch (Exception $e) {
            DB::rollback();
            if ($e instanceof ClassCancelTimeOverException) {
                throw $e;
            }

            throw new Exception(trans('error.server_error'));
        }
    }
    
     //create by ketan
     /**
     * Method createClass
     *
     * @param array $data [explicite description]
     *
     * @return ClassWebinar
     */
    public function createClassaftercheckout(array $data): ClassWebinar
    {
       
        try {
            DB::beginTransaction();
            DB::commit();
            return $this->create($data);
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }



}
