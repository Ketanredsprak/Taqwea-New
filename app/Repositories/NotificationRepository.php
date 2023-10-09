<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Services\NotificationService;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;

/**
 * Class UserRepository.
 *
 * @package namespace App\Repositories;
 */
class NotificationRepository extends BaseRepository
{

    protected $notificationService;

    protected $userDeviceRepository;

    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct(
        Application $app,
        NotificationService $notificationService,
        UserDeviceRepository $userDeviceRepository
    ) {
        parent::__construct($app);
        $this->notificationService = $notificationService;
        $this->userDeviceRepository = $userDeviceRepository;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Notification::class;
    }


    /**
     * Method getUserNotifications
     *
     * @param $request $request [explicite description]
     *
     * @return void
     */
    public function getUserNotifications($request)
    {
        $user = $request['user'];
        $limit = !empty($request['per_page']) ? $request['per_page'] : defaultPaginationLimit();
        return $this->where('to_id', $user->id)
            ->with('fromUser:id,profile_image')
            ->whereHas('fromUser')
            ->orderBy('id', 'desc')
            ->paginate($limit);
    }

    /**
     * Method deleteNotification
     *
     * @param int $id [explicite description]
     *
     * @return void
     */
    public function deleteNotification($id)
    {
        return $this->delete($id);
    }

    /**
     * Method clearAllNotification
     *
     * @param $request $request [explicite description]
     *
     * @return void
     */
    public function clearAllNotification($request)
    {
        $user = $request['user'];
        return $this->where('to_id', $user->id)->delete();
    }

    /**
     * Method saveNotifications
     *
     * @param array   $request [explicite description]
     * @param boolean $isSend  [explicite description]
     *
     * @return object
     */
    public function saveNotifications($request, $isSend = true)
    {
        if ($isSend) {
            $this->sendNotification($request, false);
        }
        $request['notification_data'] = json_encode($request);
        return $this->create($request);
    }
    
    /**
     * Method readAllNotification
     *
     * @return object
     */
    public function readAllNotification()
    {
        $user = request('user');
        return $this->where('to_id', $user->id)->update(['is_read' => '1']);
    }
    
    /**
     * Method sendNotification
     *
     * @param array   $data   [explicite description]
     * @param boolean $isSave [explicite description]
     *
     * @return void
     */
    public function sendNotification($data, $isSave)
    {
        $tokens = [];
        $type = Notification::type($data['type']);
        if (!empty($data['to_id'])) {
           
            $userDevices = $this->userDeviceRepository
                ->getDeviceByUser($data['to_id'], false);
           
            foreach ($userDevices as $userDevice) {
                if ($userDevice->device_id) {
                    $tokens[] = $userDevice->device_id;
                }
            }
            
            if ($isSave) {
                $notificationData = [
                   'from_id' => $data['from_id'],
                    'to_id' => $data['to_id'],
                    'type' => $type,
                    'notification_message' => $data['notification_message'],
                ];

                if (!empty($data['extra_data'])) {
                    $notificationData['extra_data'] = $data['extra_data'];
                }
                $this->saveNotifications($notificationData, false);
            }
        }
       
        // if (!empty($tokens)) {
        //     return $this->notificationService->sendNotification(
        //         $tokens,
        //         $type,
        //         $data['notification_message'],
        //         $data['extra_data']
        //     );
        // }
    }
}
