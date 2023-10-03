<?php

namespace App\Listeners;

use App\Console\Commands\CancelClass;
use App\Events\ClassCancelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;
use App\Repositories\ClassBookingRepository;
use App\Repositories\NotificationRepository;
use App\Mail\CancelBooking;
use App\Mail\StudentCancelledClass;
use App\Models\ClassWebinar;
use Illuminate\Support\Facades\Log;

class NotifyClassCancel implements ShouldQueue
{
    protected $event;

    protected $notificationRepository;

    protected $classBookingRepository;

    /**
     * Create a instance.
     *
     * @param NotificationRepository $notificationRepository
     * @param ClassBookingRepository $classBookingRepository
     *
     * @return void
     */
    public function __construct(
        NotificationRepository $notificationRepository,
        ClassBookingRepository $classBookingRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->classBookingRepository = $classBookingRepository;
    }

    /**
     * Handle the event.
     *
     * @param ClassCancelEvent $event
     *
     * @return void
     */
    public function handle(ClassCancelEvent $event)
    {
        $userLang = config('app.locale');
        // Send notification for student
        if ($event->data['user_type'] === User::TYPE_TUTOR) {
            $booking = $this->classBookingRepository
                ->getBooking($event->data['booking_id']);
            if ($booking) {
                $type = ($booking->class->class_type == ClassWebinar::TYPE_CLASS)?
                    'student_class_cancel':'student_webinar_cancel';
                $cancelled_type = ($booking->class->class_type == ClassWebinar::TYPE_CLASS)?
                    'class_cancelled':'webinar_cancelled';
                //setUserLanguage($booking->student->language);
                $notificationData = [
                    'from_id' => ($booking->class->tutor) ? $booking->class->tutor->id : null,
                    'to_id' => $booking->student->id,
                    'type' => $type,
                    'notification_message' =>  trans(
                        "message.class_cancel_notification",
                        [
                            "type" => $booking->class->class_type == 'class' ? trans('labels.class'): trans('labels.webinar'),
                            "className" => $booking->class->class_name,
                            "tutorName" => $booking->class->tutor()->withTrashed()->getResults()->translateOrDefault()->name,
                            'startTime' => convertDateToTz(
                                $booking->class->start_time,
                                'UTC',
                                'd M Y h:i A',
                                $booking->student->time_zone
                            )
                        ]
                    ),
                    "extra_data" => [
                        'type' =>  $cancelled_type,
                        "id" => $booking->class->id,
                        "slug" => $booking->class->slug,
                        "booking_id" => $booking->id,
                        'url' => route('home')
                    ],
                ];
                $this->notificationRepository
                    ->sendNotification($notificationData, true);
                // mail send
                 $emailTemplate = new CancelBooking($booking);
                 sendMail($booking->student->email, $emailTemplate);
            }
        }
        // Send notification for tutor
        if ($event->data['user_type'] === User::TYPE_STUDENT) {
            $booking = $this->classBookingRepository
                ->getBooking($event->data['booking_id']);
            if ($booking) {
                $type = ($booking->class->class_type == ClassWebinar::TYPE_CLASS)?
                    'tutor_class_cancel':'tutor_webinar_cancel';
                $cancelled_type = ($booking->class->class_type == ClassWebinar::TYPE_CLASS)?
                    'tutor_class_cancelled':'tutor_webinar_cancelled';

                $url = ($booking->class->class_type == ClassWebinar::TYPE_CLASS)?
                route('tutor.classes.detail', ["slug" => $booking->class->slug]):
                route('tutor.webinars.detail', ["slug" => $booking->class->slug]);
                //setUserLanguage($booking->class->tutor->language);
                $notificationData = [
                    'from_id' => $booking->student->id,
                    'to_id' => $booking->class->tutor->id,
                    'type' => $type,
                    'notification_message' =>  trans(
                        "message.tutor_class_cancelled_notification",
                        [
                            "type" => $booking->class->class_type == 'class' ? trans('labels.class'): trans('labels.webinar'),
                            "className" => $booking->class->class_name,
                            "studentName" => $booking->student->name,
                        ]
                    ),
                    "extra_data" => [
                        'type' =>  $cancelled_type,
                        "id" => $booking->class->id,
                        "slug" => $booking->class->slug,
                        "booking_id" => $booking->id,
                        "url" => $url
                    ],
                ];
                $this->notificationRepository
                    ->sendNotification($notificationData, true);
                    //mail send
                    $emailTemplate = new StudentCancelledClass($booking);
                    sendMail($booking->class->tutor->email, $emailTemplate);
            }
        }
        //setUserLanguage($userLang);

    }
}
