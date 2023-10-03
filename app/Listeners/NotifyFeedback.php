<?php

namespace App\Listeners;

use App\Events\FeedbackEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Repositories\NotificationRepository;


class NotifyFeedback implements ShouldQueue
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
     * @param FeedbackEvent $event 
     * 
     * @return void
     */
    public function handle(FeedbackEvent $event)
    {
        if ($event->feedback["from"]->user_type == User::TYPE_STUDENT) {
            $notificationData = [
                'from_id' => $event->feedback["from_id"],
                'to_id' => $event->feedback["to_id"],
                'type' =>'tutor_received_feedback',
                'notification_message' =>  trans(
                    "message.tutor_feedback_notification",
                    [
                        "tutorName" => $event->feedback["to"]->name,
                        "studentName" => $event->feedback["from"]->name,
                        "className" => $event->feedback["class"]->class_name
                    ]
                ),
                "extra_data" => [
                    'type' => "tutor_feedback",
                    'url' => route('tutor.rating.index'),
                    "id" => $event->feedback["class"]->id
                ],                   
            ];
            $this->notificationRepository
                ->sendNotification($notificationData, true);
        }
       
    }
}
