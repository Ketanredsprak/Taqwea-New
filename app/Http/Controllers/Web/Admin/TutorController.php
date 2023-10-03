<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\ClassRepository;
use App\Repositories\TutorEducationRepository;
use App\Repositories\TutorCertificateRepository;
use App\Http\Requests\Admin\TutorEditFormRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Models\ClassWebinar;
use Illuminate\Support\Str;
use App\Mail\AdminApprovedByTutor;
use Illuminate\Support\Facades\Auth;

/**
 * TutorController class
 */
class TutorController extends Controller
{

    protected $userRepository;

    protected $classRepository;

    protected $dateFormate;

    protected $tutorEducationRepository;

    protected $tutorCertificateRepository;

    /**
     * Function __construct
     * 
     * @param UserRepository             $userRepository  
     * @param ClassRepository            $classRepository  
     * @param TutorEducationRepository   $tutorEducationRepository 
     * @param TutorCertificateRepository $tutorCertificateRepository 
     * 
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        ClassRepository $classRepository,
        TutorEducationRepository   $tutorEducationRepository,
        TutorCertificateRepository $tutorCertificateRepository 
    ) {
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
        $this->dateFormate = 'Y-m-d H:i:s';
        $this->tutorEducationRepository = $tutorEducationRepository;
        $this->tutorCertificateRepository = $tutorCertificateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tutors.tutor-index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request 
     *  
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
     * 
     * @return Response
     */
    public function show($id)
    {
        $user = $this->userRepository->findUser($id);
        if (!$user) {
            abort(404);
        }
        return view('admin.tutors.view-tutor', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id 
     * 
     * @return Response
     */
    public function edit($id)
    {
        try {
            $user = $this->userRepository->findUser($id);
            return view('admin.tutors.edit-tutor', compact('user'));
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TutorEditFormRequest $request  
     * @param int                  $id   
     * 
     * @return Response
     */
    public function update(TutorEditFormRequest $request, $id)
    {
        try {
            $data = $request->all();
            $result = $this->userRepository->updateUser($data, $id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.edit_tutor')
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id 
     * 
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Method list
     *
     * @param Request $request 
     * 
     * @return collection
     */
    public function tutorList(Request $request)
    {
        $data = $this->userRepository->getUsers($request->all());
        return UserResource::collection($data);
    }

    /**
     * Method approveOrReject
     *
     * @param Request $request 
     * @param User    $tutor  
     * @param string  $status 
     * 
     * @return void
     */
    public function approveOrReject(
        Request $request,
        User $tutor,
        string $status
    ) {
        try {
            $data = $request->all();
            $data['approval_status'] = $status;
            $data['is_approved'] = ($status == 'approved') ? 1 : 0;
            $result = $this->userRepository->updateUser(
                $data,
                $tutor->id
            );
            if(!empty($result->approval_status) == 'approved' && $result->is_approved == 1)
            {   
                $emailTemplate = new AdminApprovedByTutor($result);
                sendMail($result->email, $emailTemplate);
            }
            return response()->json(
                ['success' => true, 'message' => trans('message.update_status')]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Method verificationStatus
     *
     * @param Request $request 
     * @param User    $tutor  
     * @param string  $status 
     * 
     * @return void
     */
    public function verificationStatus(
        Request $request,
        User $tutor,
        string $status
    ) {
        try {
            $data['is_verified'] = $status;
            $this->userRepository->updateUser(
                $data,
                $tutor->id
            );
            return response()->json(
                ['success' => true, 'message' => trans('message.is_verified')]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Method Schedule  
     * 
     * @param Request $request 
     * @param $tutorId 
     * 
     * @return response
     */
    public function schedule(Request $request, $tutorId)
    {
        try {
            $timezone = Session::get('timezone') ?? config('app.timezone');
            $params['userTimezone'] = Carbon::createFromTimestamp(
                0,
                $timezone
            )->getOffsetString();
            $params['status'] = ClassWebinar::STATUS_ACTIVE;
            $now = Carbon::now();
            $startDate = $now->format('Y-m-d');
            $monthEndDate = $now->endOfMonth()->format('Y-m-d');
            $params['start_time'] = $startDate;
            $params['end_time'] = $monthEndDate;

            $params['tutor_id'] = $tutorId;
            $params["group_by_start_date"] = true;
            if (isset($request->gridView) && $request->gridView != "month") {
                $params["group_by_start_date"] = false;
            }

            $classes =  $this->classRepository
                ->getClasses($params);
            if (!empty($classes)) {
                $events = [];
                foreach ($classes as $class) {
                    $startDate = convertDateToTz(
                        $class->start_time,
                        'UTC',
                        'Y-m-d'
                    );
                    $class_count= ClassWebinar::classScheduleCount($tutorId, $params['userTimezone'],  $startDate);
                    $events[] = [
                        'title' => $class_count .' Availability',
                        'start' =>  convertDateToTz(
                            $class->start_time,
                            'UTC',
                            $this->dateFormate
                        ),
                        'end' =>  convertDateToTz(
                            $class->end_time,
                            'UTC',
                            $this->dateFormate
                        )
                    ];
                }
                return response()->json($events);
            }
            return $request;
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Method Schedule  
     * 
     * @param Request $request 
     * @param $tutorId 
     * 
     * @return response
     */
    public function scheduleList(Request $request, $tutorId)
    {
        try {
            $timezone = Session::get('timezone') ?? config('app.timezone');
            $params['userTimezone'] = Carbon::createFromTimestamp(
                0,
                $timezone
            )->getOffsetString();
            $params['status'] = ClassWebinar::STATUS_ACTIVE;

            if ($request->gridView != 'dayGridMonth') {
                $params['start_date_time']
                    = convertDateToTz(
                        $request->start_time,
                        $timezone,
                        $this->dateFormate,
                        'UTC'
                    );
            } else {
                $params['schedule_date'] = Carbon::parse(
                    $request->start_time
                )->format('Y-m-d');
            }

            $params['tutor_id'] = $tutorId;
            $classes =  $this->classRepository
                ->getClasses($params);
            if (!empty($classes)) {
                return view(
                    'admin.tutors.tutor-schedule-list',
                    ['classes' => $classes]
                );
            }
            return $request;
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Method Download Education 
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function downloadEducationDoc(int $id)
    {
       
        try {
            $data = $this->tutorEducationRepository->findEducation($id);
            if ($data) {
                return $this->apiSuccessResponse($data);
            } else {
                return $this->apiErrorResponse(trans('message.something_went_wrong'), 422);
            }
           
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Method Download experience 
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function downloadExperienceDoc(int $id)
    {
        try {
            $data = $this->tutorCertificateRepository->findCertificate($id);
            if ($data) {
                return $this->apiSuccessResponse($data);
            } else {
                return $this->apiErrorResponse(trans('message.something_went_wrong'), 422);
            }
           
        } catch (\Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }
}
