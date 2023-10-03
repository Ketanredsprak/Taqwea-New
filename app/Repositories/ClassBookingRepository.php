<?php

namespace App\Repositories;

use App\Exceptions\ClassCancelTimeOverException;
use App\Models\ClassBooking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Exception;
use App\Repositories\TransactionItemRepository;
use App\Events\ClassCancelEvent;
use App\Mail\StudentCancelledClass;

class ClassBookingRepository extends BaseRepository
{

    /**
     * Method __construct
     *
     * @param Application $app
     *
     * @return void
     */
    public function __construct(
        Application $app,
        TransactionItemRepository $transactionItemRepository
    ) {
        parent::__construct($app);
        $this->transactionItemRepository = $transactionItemRepository;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return ClassBooking::class;
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
     * Method getBookings
     *
     * @param array $params [explicite description]
     *
     * @return Collection
     */
    public function getBookings(array $params = [])
    {
        $language = getUserLanguage($params);
        /**
         * User
         *
         * @var $loggedInUser User
         **/
        $loggedInUser = Auth::user();
        $sortFields = [
            'id' => 'id',
            'student_name' => 'user_translations.name',
            'class_name' => 'class_webinar_translations.class_name',
            'start_date' => 'class_webinars.start_time',
            'class_duration' => 'class_webinars.duration',
            'amount_paid' => 'class_webinars.total_fees',
            'booking_date' => 'class_bookings.created_at',
            'status' => 'class_bookings.status',
        ];
        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->select('class_bookings.*')
            ->leftjoin(
                'class_webinars',
                'class_webinars.id',
                'class_bookings.class_id'
            )
            ->leftjoin(
                'user_translations',
                'user_translations.user_id',
                'class_bookings.student_id'
            )
            ->leftjoin(
                'class_webinar_translations',
                'class_webinars.id',
                'class_webinar_translations.class_webinar_id'
            )
            ->leftjoin(
                'transaction_items',
                'class_bookings.class_id',
                'transaction_items.class_id'
            );

        $query->with(
            [
                'class.bookings' =>
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

        if (Auth::check() && $loggedInUser->isAdmin()) {

            $query->whereRaw(
                "if(user_translations.language IS NOT NULL,
                user_translations.language= '" . $language . "',
                true )"
            );
            $query->whereRaw(
                "if(class_webinar_translations.language IS NOT NULL,
                class_webinar_translations.language= '" . $language . "',
                true )"
            );
        }

        if (!empty($params['self']) && Auth::check()) {
            if ($loggedInUser->isTutor()) {
                $query->where('class_webinars.tutor_id', Auth::user()->id);
            } elseif ($loggedInUser->isStudent()) {
                $query->where('class_bookings.student_id', Auth::user()->id);
            }
        }

        if (!empty($params['class_type'])) {
            $query->where('class_type', $params['class_type']);
        }

        if (!empty($params['class_id'])) {
            $query->where('class_webinars.id', $params['class_id']);
        }

        if (!empty($params['confirm'])) {
            $query->where('class_bookings.class_id', $params['class_id'])->whereIn(
                'class_bookings.status',
                [
                    ClassBooking::STATUS_CONFIRMED,
                    ClassBooking::STATUS_COMPLETED,
                    ClassBooking::STATUS_CANCELLED
                ]
            );
            $query->whereNull('parent_id')
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

        if (!empty($params['search'])) {
            $query->where(
                function ($qry) use ($params) {
                    $qry->where(
                        'class_webinar_translations.class_name',
                        'like',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'user_translations.name',
                        'like',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'class_bookings.id',
                        $params['search']
                    );
                }
            );
        }

        if (!empty($params['no_of_attendee'])) {
            $query->where('no_of_attendee', $params['no_of_attendee']);
        }

        if (!empty($params['start_time'])) {
            $query->whereDate('start_time', '>=', $params['start_time']);
        }

        if (!empty($params['end_time'])) {
            $query->whereDate('start_time', '<=', $params['end_time']);
        }

        if (!empty($params['booking_start_time'])) {
            $query->whereDate(
                'class_bookings.created_at',
                '>=',
                $params['booking_start_time']
            );
        }

        if (!empty($params['booking_end_time'])) {
            $query->whereDate(
                'class_bookings.created_at',
                '<=',
                $params['booking_end_time']
            );
        }


        if (!empty($params['status'])) {
            $query->where('class_webinars.status', $params['status']);
        }

        if (!empty($params['booking_status'])) {
            if ($params['booking_status'] == 'upcoming') {
                $query->where(
                    'class_bookings.status',
                    ClassBooking::STATUS_CONFIRMED
                )->whereNull('parent_id');
            } elseif ($params['booking_status'] == 'past') {
                $query->whereIn(
                    'class_bookings.status',
                    [
                        ClassBooking::STATUS_CANCELLED,
                        ClassBooking::STATUS_COMPLETED,
                    ]
                )->whereNull('parent_id');
            } else {
                $query->where(
                    'class_bookings.status',
                    $params['booking_status']
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

        $sort = $sortFields['start_date'];
        $direction = 'asc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }
        $query->where('parent_id', null);
        $query->orderBy($sort, $direction);

        $query->groupBy('class_bookings.id');

        return $query->paginate($size);
    }

    /**
     * Method getBooking
     *
     * @param int $id [explicite description]
     *
     * @return ClassBooking
     */
    public function getBooking(int $id)
    {
        return $this->find($id);
    }

    /**
     * Method createBooking
     *
     * @param array $data [explicite description]
     *
     * @return ClassBooking
     */
    public function createBooking(array $data): ClassBooking
    {
        $this->checkBooking($data);
        $data["status"] = ClassBooking::STATUS_CONFIRMED;
        return $this->create($data);
    }

    /**
     * Method updateBooking
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     *
     * @return ClassBooking
     */
    public function updateBooking(array $data, int $id): ClassBooking
    {
        return $this->update($data, $id);
    }

    /**
     * Method updateBookingStatus
     *
     * @param int    $id     [explicite description]
     * @param string $status [explicite description]
     *
     * @return ClassBooking
     */
    public function updateBookingStatus(
        int $id,
        string $status
    ): ClassBooking {
        if ($status == 'joined') {
            $data["is_joined"] = 1;
        } else {
            $data['status'] = $status;
        }

        if ($status == ClassBooking::STATUS_CANCELLED && Auth::check()) {
            $dataCancelledBooking = [
                'user_id' => Auth::user()->id,
                'booking_id' => $id,
                'user_type' => Auth::user()->user_type
            ];
            $this->cancelBooking($dataCancelledBooking);

        }
        return $this->updateBooking($data, $id);
    }

    /**
     * Method checkBooking
     *
     * @param array $data
     *
     * @return bool
     */
    public function checkBooking($data): bool
    {
        $count = $this->where(
            [
                "class_id" => $data['class_id'],
                "student_id" => $data["student_id"]
            ]
        )->count();
        if ($count) {
            throw new Exception(trans('error.class_booked'));
        }
        return true;
    }

    /**
     * Check class already book at same time
     *
     * @param $startTime [explicite description]
     * @param $duration  [explicite description]
     * @param $studentId [explicite description]
     *
     * @return ClassBooking
     */
    public function checkStudentBooking(
        $startTime,
        $duration,
        $studentId,
        $classId = null
    ) {
        $endTime = Carbon::parse($startTime)->addMinutes($duration);
        $query = $this->whereHas(
            'class',
            function ($q) use ($startTime, $endTime, $classId) {
                $q->checkExists($startTime, $endTime);

                if ($classId) {
                    $q->where('id', '<>', $classId);
                }
            }
        )
            ->where(['student_id' => $studentId, 'status' => 'confirm']);
        return $query->first();
    }

    /**
     * Method cancel booking
     *
     * @param array $data
     *
     * @return Object
     */
    public function cancelBooking(array $data = [])
    {

        try {
            $booking = $this->where(['id' => $data['booking_id']])->first();
            if ($booking) {
                DB::beginTransaction();
                $currentTime = currentDateByFormat('Y-m-d H:i:s');
                $classCancelTime = config('services.class_cancel_before');
                $currentTime = Carbon::parse($currentTime);
                if (empty($data['is_system'])
                    && $booking->class->start_time < $currentTime
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

                $booking->update(
                    [
                        'status' => ClassBooking::STATUS_CANCELLED,
                        'cancelled_by' => $data['user_id']
                    ]
                );

                $bookingItem = [
                    'class_id' => $booking->class_id,
                    'student_id' => $booking->student_id,
                    'current_time' => $currentTime,
                    'class_time' => @$booking->class->start_time,
                    'user_type' => $data['user_type'],
                ];
                $this->transactionItemRepository
                    ->cancelTransactionItem($bookingItem);

                ClassCancelEvent::dispatch($data);

                DB::commit();
                return true;
            }
        } catch (Exception $e) {
            DB::rollback();
            if ($e instanceof ClassCancelTimeOverException) {
                throw $e;
            }
            throw new Exception(trans('error.server_error'));
        }
    }

    /**
     * Method end booking call
     *
     * @param int $classId
     *
     * @return Object
     */
    public function getStudentBookingByClassId($classId)
    {
        try {
            $studentId = Auth::user()->id;
            $booking = $this->where(
                [
                    'class_id' => $classId,
                    'student_id' => $studentId,
                    'status' => ClassBooking::STATUS_CONFIRMED
                ]
            )->first();
            if ($booking) {
                return $booking;
            }
            return false;
        } catch (Exception $e) {
            throw new Exception(trans('error.server_error'));
        }
    }

    /**
     * Method end booking call
     *
     * @param array $data
     *
     * @return bool
     */
    public function completeBooking(array $data = [])
    {
        try {
            $booking = $this->where(['id' => $data['booking_id']])->first();
            if ($booking) {
                $booking->update(
                    [
                        'status' => ClassBooking::STATUS_COMPLETED
                    ]
                );
                return true;
            }
            return false;
        } catch (Exception $e) {
            throw new Exception(trans('error.server_error'));
        }
    }

    /**
     * Function Search
     *
     * @param array $params
     *
     * @return object
     */
    public function search(array $params = [])
    {
        $query = $this->where('class_id', $params['id'])
            ->whereNull('parent_id')
            ->where('status', '<>', ClassBooking::STATUS_CANCELLED)
            ->with(
                [
                    "rating"=>
                    function ($query) use ($params) {
                        $query->where('class_id', $params['id']);
                    }
                ]
            );

        if (isset($params['student_id'])) {
            return $query->where('student_id', $params['student_id'])->first();
        }

        if (isset($params['name']) && !empty($params['name'])) {
            $query->whereHas(
                'student',
                function ($subQuery) use ($params) {
                    $subQuery->whereTranslationLike(
                        'name',
                        "%" . $params['name'] . "%"
                    );
                }
            );
        }
        return $query->get();
    }
}
