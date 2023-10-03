<?php

namespace App\Listeners;

use App\Events\ClassCompletedEvent;
use App\Mail\BookingComplete;
use App\Models\ClassWebinar;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\ClassBookingRepository;
use App\Repositories\NotificationRepository;

class NotifyClassCompleted implements ShouldQueue
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
     * @param ClassCompletedEvent $event 
     * 
     * @return void
     */
    public function handle(ClassCompletedEvent $event)
    {  
        $userLang = config('app.locale');
        // send notification
        $booking = $this->classBookingRepository
            ->getBooking($event->data['booking_id']);
        if ($booking) {
            $type = ($booking->class->class_type == ClassWebinar::TYPE_CLASS)?
            'class_completed':'webinar_completed';
            $cancelled_type = ($booking->class->class_type == ClassWebinar::TYPE_CLASS)?
            'class_completed':'webinar_completed';

            $url = ($booking->class->class_type == ClassWebinar::TYPE_CLASS)?
            route('classes/show', ["class" => $booking->class->slug]):
            route('webinars/show', ["class" => $booking->class->slug]);

            //setUserLanguage($booking->student->language);
            $notificationData = [
                'from_id' => $booking->class->tutor->id,
                'to_id' => $booking->student->id,
                'type' => $type,
                'notification_message' =>  trans(
                    "message.class_completed_notification",
                    [
                        "type" => $booking->class->class_type == 'class' ? trans('labels.class'): trans('labels.webinar'),
                        "className" => $booking->class->class_name,
                    ]
                ),
                "extra_data" => [
                    'type' =>  $cancelled_type,
                    "id" => $booking->class->id,
                    "slug" => $booking->class->slug,
                    "booking_id" => $booking->id,
                    'url' => $url
                ],                   
            ];
            $this->notificationRepository
                ->sendNotification($notificationData, true);
            // mail send
            $emailTemplate = new BookingComplete($booking);
            sendMail($booking->student->email, $emailTemplate);
        } 
        //setUserLanguage($userLang);
    }
}
