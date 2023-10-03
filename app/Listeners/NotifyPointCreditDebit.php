<?php

namespace App\Listeners;

use App\Events\PointCreditDebitEvent;
use App\Mail\PointCreditDebit;
use App\Models\RewardPoint;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\NotificationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;



/**
 * Listener NotifyPointCreditDebit 
 */
class NotifyPointCreditDebit implements ShouldQueue
{
    protected $notificationRepository;

    protected $userRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationRepository $notificationRepository, UserRepository $userRepository)
    {
        $this->notificationRepository = $notificationRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Handle the event.
     *
     * @param PointCreditDebitEvent $event 
     * 
     * @return void
     */
    public function handle(PointCreditDebitEvent $event)
    {
        $data['user_id'] = $event->data['user_id'];
        $user = $this->userRepository->getUserByAttribute($data);
        //setUserLanguage($user->language);
        $emailData = [
            'name' => $user->name,
            'no_of_points' => $event->data['points'],
            'total_point' => RewardPoint::getUserPoints($event->data['user_id']),
            'type' => $event->data['type']
        ];
        $emailTemplate = new PointCreditDebit($emailData);
        sendMail($user->email, $emailTemplate);

        $notificationData = [
            'from_id' => $event->data['from_id'],
            'to_id' => $event->data['user_id'],
            'type' =>'reward_point',
            'notification_message' =>  trans(
                "message.tutor_reward_point",
                [
                    "type" => $event->data['type'] == 'credit' ? trans("message.credit") : trans("message.debit"),
                ]
            ),
            "extra_data" => [
            ],                   
        ];
        $this->notificationRepository
            ->sendNotification($notificationData, true);
    }
}
