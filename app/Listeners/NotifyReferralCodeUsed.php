<?php

namespace App\Listeners;

use App\Events\ReferralCodeUsedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\UserRepository;
use App\Repositories\NotificationRepository;
use App\Mail\ReferralUsed;

class NotifyReferralCodeUsed implements ShouldQueue
{
    protected $userRepository;

    protected $notificationRepository;

    /**
     * Create the event listener.
     *
     * @param NotificationRepository $notificationRepository 
     * @param UserRepository         $userRepository 
     * 
     * @return void
     */
    public function __construct(NotificationRepository $notificationRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Handle the event.
     *
     * @param ReferralCodeUsedEvent $event 
     * 
     * @return void
     */
    public function handle(ReferralCodeUsedEvent $event)
    {
        $params['referral_code'] = $event->data["referral_code"];
        
        $name = isset($event->data['en']['name'])?$event->data['en']['name']:@$event->data["name"];
        
        $user = $this->userRepository->findUser('', $params);
        if ($user) {
            $notificationData = [
                'from_id' => $event->data["user"]->id,
                'to_id' => $user->id,
                'type' =>'referral_code_used',
                'notification_message' =>  trans(
                    "message.referral_code_used_notification",
                    ['name' => $name ]
                ),
                "extra_data" => [
                    'type' => "referral_code_used",
                    'url' => route('home')
                ],                   
            ];
            $this->notificationRepository
                ->sendNotification($notificationData, true);
            // mail send
            $emailTemplate = new ReferralUsed($event->data, $user);
            sendMail($user->email, $emailTemplate);
        }
    }
}
