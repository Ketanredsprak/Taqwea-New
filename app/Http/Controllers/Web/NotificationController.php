<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use App\Repositories\NotificationRepository;
use App\Services\NotificationService;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * NotificationController Class 
 */
class NotificationController extends Controller
{
    protected $notificationRepository;
    protected $notificationService;

    /**
     * Function __construct
     * 
     * @param NotificationRepository $notificationRepository 
     * @param NotificationService    $notificationService 
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
     * Function index get all notification
     * 
     * @param Request $request 
     * 
     * @return view
     */
    public function index(Request $request)
    {
        $this->notificationRepository->readAllNotification();
        $data = $this->notificationRepository
            ->getUserNotifications($request);
        return view('frontend.notification.notification', compact('data'));
    }
    
    /**
     * Method sendNotification
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function sendNotification(Request $request)
    {
        try{
            $userId = $request->user_id;
            $device = UserDevice::where('user_id', $userId)->first();
            $sent = $this->notificationService->sendNotification(
                [
                    $device->device_id
                ],
                'Testing Taqwea',
                'You have new testing notification',
                ['a_data' => 'my_data']
            );

            if ($sent) {
                echo 'Notification has been sent';
                exit;
            }

            echo 'Notification not sent';
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
}
