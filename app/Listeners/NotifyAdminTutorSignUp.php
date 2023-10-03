<?php

namespace App\Listeners;

use App\Events\TutorSignUpEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\NotificationRepository;
use App\Models\User;

class NotifyAdminTutorSignUp implements ShouldQueue
{
    protected $notificationRepository;
    /**
     * Create a instance.
     *
     * @param NotificationRepository $notificationRepository 
     * 
     * @return void
     */
    public function __construct(
        NotificationRepository $notificationRepository
    ) {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Handle the event.
     *
     * @param TutorSignUpSubscriptionEvent $event 
     * 
     * @return void
     */
    public function handle(TutorSignUpEvent $event)
    {
        $admin = User::getAdmin();
        $notificationData = [
            'from_id' => $event->data['id'],
            'to_id' =>  @$admin->id,
            'type' =>'admin_tutor_signup',
            'notification_message' =>  trans(
                "message.admin_tutor_signup_notification", ["tutorName" => $event->data['name']]
            ),
            "extra_data" => [
                'type' => "tutor_signup",
                'url' => route('tutors.index')
            ],                   
        ];
        $this->notificationRepository
            ->sendNotification($notificationData, true);
    }
}
