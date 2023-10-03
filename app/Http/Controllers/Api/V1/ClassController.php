<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddClassRequest;
use App\Http\Requests\Api\RaiseDisputeRequest;
use App\Http\Requests\Api\UpdateClassRequest;
use App\Http\Resources\V1\ClassResource;
use App\Http\Resources\V1\AvailableClassResource;
use App\Models\ClassWebinar;
use App\Repositories\ClassRepository;
use App\Repositories\ClassRefundRequestRepository;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Services\AgoraService;
use Codiant\Agora\RtcTokenBuilder;
use Log;

class ClassController extends Controller
{
    protected $classRepository;

    protected $classRefundRequestRepository;

    protected $agoraService;
    
    /**
     * Method __construct
     *
     * @param ClassRepository              $classRepository 
     * @param ClassRefundRequestRepository $classRefundRequestRepository 
     * @param AgoraService                 $agoraService 
     * 
     * @return void
     */
    public function __construct(
        ClassRepository $classRepository,
        ClassRefundRequestRepository $classRefundRequestRepository,
        AgoraService $agoraService
    ) {
        $this->authorizeResource(ClassWebinar::class, 'class');
        $this->classRepository = $classRepository;
        $this->classRefundRequestRepository = $classRefundRequestRepository;
        $this->agoraService = $agoraService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data = $request->all();
            if (!empty($data["start_date"])) {
                $data["start_time"] = $data["start_date"];
                $data['today'] = true;
            }
            $classes = $this->classRepository
                ->getClasses($data, "simplePaginate");
            return ClassResource::collection($classes);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request 
     * 
     * @return ClassResource
     */
    public function store(AddClassRequest $request)
    {
        try {
            $data = $request->all();
            dd($data);
            $class = $this->classRepository->createClass($data);
            return new ClassResource($class);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ClassWebinar $class 
     * 
     * @return ClassResource
     */
    public function show(ClassWebinar $class)
    {
        try {
            $params = [];
            $result = $this->classRepository->getClass($class->id, $params);
            return new ClassResource($result);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClassRequest $request 
     * @param ClassWebinar       $class 
     * 
     * @return ClassResource
     */
    public function update(
        UpdateClassRequest $request,
        ClassWebinar $class
    ) {
        try {
            $data = $request->all();
            $timezone = $request->header('time-zone');
            $classStartTime = changeDateToFormat($data["start_time"], 'Y-m-d H:i:s');
            $data['start_time'] = convertDateToTz($classStartTime, $timezone, 'Y-m-d H:i:s', 'UTC');
            if ($data['start_time'] < Carbon::now()) {
                throw new Exception(__('message.class_invalid_time'));
            }

            $class = $this->classRepository->updateClass($data, $class->id);
            return new ClassResource($class);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
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
            $class = $this->classRepository->deleteClass($class->id);
            return $this->apiDeleteResponse();
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
    
    /**
     * Method publish
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
            return new ClassResource($class);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method raiseDispute
     * 
     * @param RaiseDisputeRequest $request 
     * @param ClassWebinar        $class 
     * 
     * @return void
     */
    public function raiseDispute(
        RaiseDisputeRequest $request,
        ClassWebinar $class
    ) {
        try {
            $data = $request->all();
            $this->classRefundRequestRepository->createRefundRequest($class, $data);
            return $this->apiSuccessResponse(
                [],
                trans('message.class_refund_request')
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method updateStatus
     *
     * @param Request $request 
     * @param int     $class 
     * @param string  $action  
     * 
     * @return ClassResource
     */
    public function updateStatus(
        Request $request,
        int $class,
        string $action
    ) {
        try {
            $data["class_id"] = $class;
            if (Auth::check()) {
                $data['user_id'] = Auth::user()->id;
            }

            if ($action == ClassWebinar::STATUS_CANCELLED) {
                $class = $this->classRepository->cancelClass($data);
            }

            if ($action == ClassWebinar::STATUS_COMPLETED) {
                $class = $this->classRepository->completeClass($data);
            }

            if ($action == ClassWebinar::STARTED) {
                $data['is_started'] = 1;
                $class = $this->classRepository->updateClass($data, $class);
            }

            return $this->apiSuccessResponse(
                [],
                trans('message.class_updated')
            );
            
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method available current week
     * 
     * @param Request $request 
     * 
     * @return AvailableClassResource
     */
    public function availableDate(Request $request)
    {
        try {
            $params = $request->all();
            $now = Carbon::now();
            $startDate = $now->format('Y-m-d');
            $monthEndDate = $now->addDay(30)->format('Y-m-d');
            $params['start_time'] = $startDate;
            $params['end_time'] = $monthEndDate;
            $params["group_by_start_date"] = true;
            $classes = $this->classRepository
                ->getClasses($params);
           
            return AvailableClassResource::collection($classes);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method Token
     * 
     * @param Request $request 
     * 
     * @return TokenResource
     */
    public function token(Request $request)
    {
        try {
            $class = $this->classRepository->getClass((int)$request->class);
            if (!$class) {
                throw new Exception(trans('error.class_not_available'));
            }
            $data['token'] = $this->agoraService->generateToken(
                'channel-'.$class->id,
                Auth::user()->id,
                RtcTokenBuilder::ROLE_PUBLISHER
            );
            $data['uuid'] = $class->uuid;
            $data['room_token'] = $class->room_token;
            return $this->apiSuccessResponse($data);
        }  catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
    
}
