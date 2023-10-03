<?php

namespace App\Listeners;

use App\Events\RequestDisputeEvent;
use App\Mail\StudentRequestDispute;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\ClassRefundRequestRepository;
use App\Repositories\NotificationRepository;
use App\Models\User;

/**
 * NotifyRequestDispute 
 */
class NotifyRequestDispute implements ShouldQueue
{
    protected $notificationRepository;

    protected $classRefundRequestRepository;
    /**
     * Create the event listener.
     *
     * @param NotificationRepository       $notificationRepository 
     * @param classRefundRequestRepository $classRefundRequestRepository 
     * 
     * @return void
     */
    public function __construct(
        NotificationRepository $notificationRepository,
        ClassRefundRequestRepository $classRefundRequestRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->classRefundRequestRepository = $classRefundRequestRepository;
    }

    /**
     * Handle the event.
     *
     * @param RequestDisputeEvent $event 
     * 
     * @return void
     */
    public function handle(RequestDisputeEvent $event)
    {
        $params['id'] = $event->data->id;
        $classRefund = $this->classRefundRequestRepository->getList($params);
        $accountant = User::getAccountant();
        $notificationData = [
            'from_id' => $classRefund->user_id,
            'to_id' => @$accountant->id ,
            'type' => "student_raise_dispute",
            'notification_message' =>  trans(
                "message.student_raise_dispute_notification",
                [
                    "studentName" => $classRefund->student->name ,
                    "tutorName" => $classRefund->class->tutor->name ,
                    "subjectName" => ($classRefund->class->subject)?$classRefund->class->subject->subject_name:'' ,
                ]
            ),
            "extra_data" => [
                'type' => "student_raise_dispute",
            ],
        ];
        $this->notificationRepository
            ->sendNotification($notificationData, true);
        //mail send
        $emailTemplate = new StudentRequestDispute($classRefund);
        sendMail($accountant->email, $emailTemplate);
    }
}
