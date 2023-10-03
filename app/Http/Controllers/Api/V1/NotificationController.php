<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\NotificationRepository;
use Illuminate\Http\JsonResponse;
use App\Models\UserDevice;
use App\Services\NotificationService;
use Log;

class NotificationController extends Controller
{
    protected $notificationRepository;

    protected $notificationService;

    

    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct(
        NotificationRepository $notificationRepository,
        NotificationService $notificationService
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $result = $this->notificationRepository
                ->getUserNotifications($request->all());
            if ($result) {
                return $this->apiSuccessResponse($result, '');
            } else {
                return $this->apiErrorResponse(trans('message.something_went_wrong'), 422);
            }
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }


    /**
     * Method store
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $result = $this->notificationRepository
                ->sendNotification($request->all(), false);
            if ($result) {
                return $this->apiSuccessResponse($result, '');
            } else {
                return $this->apiErrorResponse(trans('message.something_went_wrong'), 422);
            }
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }


    /**
     * Method show
     *
     * @param $id $id [explicite description]
     *
     * @return void
     */
    public function show($id)
    {
        //
    }


    /**
     * Method destroy
     *
     * @param int $id [explicite description]
     *
     * @return void
     */
    public function destroy(int $id)
    {
        try {
            $result = $this->notificationRepository->deleteNotification($id);
            if ($result) {
                return $this->apiSuccessResponse([], trans('message.notification_delete'));
            } else {
                return $this->apiErrorResponse(trans('message.something_went_wrong'), 422);
            }
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }
    /**
     * Method clearAll
     *
     * @param Request $request [explicite description]
     *
     * @return JsonResponse
     */
    public function clearAll(Request $request)
    {
        try {
            $result = $this->notificationRepository
                ->clearAllNotification($request->all());
            if ($result) {
                return $this->apiSuccessResponse([], trans('message.notification_delete'));
            } else {
                return $this->apiErrorResponse(trans('message.something_went_wrong'), 422);
            }
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }    
    /**
     * Method readAll
     *
     * @return JsonResponse
     */
    public function readAll()
    {
        try {
            $result = $this->notificationRepository->readAllNotification();
            if ($result) {
                return $this->apiSuccessResponse([], '');
            } else {
                return $this->apiErrorResponse(trans('message.something_went_wrong'), 422);
            }
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

    /**
     * Method web push
     * 
     * @param Request $request 
     * 
     * @return void 
     */
    public function webPush(Request $request)
    {
        try{
           
            $userId = $request->user_id;
            $device = UserDevice::where('user_id', $userId)->first();
            if ($device) {
                $sent = $this->notificationService->sendNotification(
                    [
                        $device->device_id
                    ],
                    'Chat Message',
                    $request->message,
                    ['user_id' =>  $request->user_id]
                );
                
                if ($sent) {
                    echo 'Notification has been sent';
                    exit;
                }
            }
            
        } catch(\Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }
}
