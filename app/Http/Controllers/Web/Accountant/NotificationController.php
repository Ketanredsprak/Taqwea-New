<?php

namespace App\Http\Controllers\Web\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\NotificationRepository;
use Illuminate\View\View;

/**
 * NotificationController class
 * 
 * @package App\Http\Controllers\Web\Accountant
 */
class NotificationController extends Controller
{
    protected $notificationRepository;

    /**
     * Method __construct
     * 
     * @param NotificationRepository $notificationRepository 
     * 
     * @return void
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Method index 
     * 
     * @param Request $request  
     * 
     * @return view 
     */
    public function index(Request $request)
    {
        $notifications = $this->notificationRepository
            ->getUserNotifications($request);
        $this->notificationRepository->readAllNotification();
        return view('accountant.notifications.index', compact('notifications'));
    }

    /**
     * Method markAllAsRead
     * 
     * @param Request $request 
     *
     * @return JsonResponse
     */
    public function markAllAsRead(Request $request)
    {
        try {
            $result = $this->notificationRepository->readAllNotification();
            if ($result) {
                return $this->apiSuccessResponse(
                    [],
                    trans('message.mark_all_as_read')
                );
            } else {
                return $this->apiErrorResponse(
                    trans(
                        'message.something_went_wrong'
                    ),
                    422
                );
            }
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }
}
