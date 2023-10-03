<?php

namespace App\Listeners;

use App\Events\TutorSignUpSubscriptionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\NotificationRepository;
use App\Models\User;
use App\Mail\TutorSignUpSubscription;
class NotifyTutorSignUpSubscription implements ShouldQueue
{
    protected $notificationRepository;

    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'default';

    
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
    public function handle(TutorSignUpSubscriptionEvent $event)
    {
        $admin = User::getAdmin();
        $notificationData = [
            'from_id' => @$admin->id,
            'to_id' => $event->data['id'],
            'type' =>'tutor_signup_assign_subscription_plan',
            'notification_message' =>  trans(
                "message.signup_assign_default_plan"
            ),
            "extra_data" => [
                'type' => "signup_assign_default_plan",
                'url' => route('tutor.subscription.index')
            ],                   
        ];
        $this->notificationRepository
            ->sendNotification($notificationData, true);
        // mail send
        $emailTemplate = new TutorSignUpSubscription($event->data);
        sendMail($event->data['email'], $emailTemplate);
    }
}
