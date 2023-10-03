<?php

namespace App\Listeners;

use App\Events\BookingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\TutorScheduleClass;
use App\Mail\StudentBookedClassWebinar;
use App\Mail\TutorScheduleClassWebinarBook;
use App\Models\ClassWebinar;
use App\Repositories\TransactionRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\ClassBookingRepository;

class NotifyTutorBooking implements ShouldQueue
{
    protected $transactionRepository;

    protected $notificationRepository;

    protected $classBookingRepository;

    /**
     * Create a instance.
     *
     * @param TransactionRepository  $transactionRepository 
     * @param NotificationRepository $notificationRepository 
     * @param ClassBookingRepository $classBookingRepository 
     * 
     * @return void
     */
    public function __construct(
        TransactionRepository $transactionRepository,
        NotificationRepository $notificationRepository,
        ClassBookingRepository $classBookingRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->notificationRepository = $notificationRepository;
        $this->classBookingRepository = $classBookingRepository;
    }

    /**
     * Handle the event.
     *
     * @param BookingEvent $event 
     * 
     * @return void
     */
    public function handle(BookingEvent $event)
    {
        $params['transaction_id'] = $event->id;
        $transaction = $this->transactionRepository->getTransaction($params);
        if ($transaction 
            && !empty($transaction->transactionItems)
            && count($transaction->transactionItems) === 1
            && $transaction->transactionItems[0]->class_id
        ) {
           
            // send mail tutor
            $emailTemplate = new StudentBookedClassWebinar($transaction->transactionItems[0]);
            sendMail($transaction->transactionItems[0]->classWebinar->tutor->email, $emailTemplate);
            // send notification tutor
            $type = ($transaction->transactionItems[0]->classWebinar->class_type == ClassWebinar::TYPE_CLASS)?
            'tutor_class_booked':'tutor_webinar_booked';
            $booking_type = ($transaction->transactionItems[0]->classWebinar->class_type == ClassWebinar::TYPE_CLASS)?
            'tutor_class_booked':'tutor_webinar_booked';

            $url = ($transaction->transactionItems[0]->classWebinar->class_type == ClassWebinar::TYPE_CLASS)?
            route('tutor.classes.detail', ["slug" => $transaction->transactionItems[0]->classWebinar->slug]):
            route('tutor.webinars.detail', ["slug" => $transaction->transactionItems[0]->classWebinar->slug]);

            $notificationData = [
                'from_id' => $transaction->transactionItems[0]->student_id,
                'to_id' => $transaction->transactionItems[0]->classWebinar->tutor->id,
                'type' => $type,
                'notification_message' =>  trans(
                    "message.tutor_booking_notification",
                    [
                        "tutorName" => $transaction->transactionItems[0]->classWebinar->tutor->name,
                        "studentName" => $transaction->transactionItems[0]->student->name,
                        "className" => $transaction->transactionItems[0]->classWebinar->class_name,
                        "type" => $transaction->transactionItems[0]->classWebinar->class_type == 'class' ? trans('labels.class'): trans('labels.webinar'),
                    ]
                ),
                "extra_data" => [
                    'type' => $booking_type,
                    'url' => $url,
                    'id' => $transaction->transactionItems[0]->classWebinar->id
                ],                   
            ];
            $this->notificationRepository
                ->sendNotification($notificationData, true);
            //Check booking count
            if ($transaction->transactionItems[0]->classWebinar->class_type == ClassWebinar::TYPE_CLASS) {
                $params["class_id"] = $transaction->transactionItems[0]->class_id;
                $params["confirm"] = true;
                $bookings = $this->classBookingRepository->getBookings($params);
                $classMaxStudent = config('services.class_max_student');
                if (count($bookings) == $classMaxStudent) {
                    $this->classFullBooking($bookings);
                }
            }
          
        } else if ($transaction 
            && !empty($transaction->transactionItems)
            && count($transaction->transactionItems) > 1
        ) {
            $tutorArray = [];
           
            foreach ($transaction->transactionItems as $items) {
                if ($items->class_id) {
                    $flag = 1;
                    foreach ($tutorArray as $key => $val) {
                        if ($val['tutor_id'] == $items->classWebinar->tutor_id) {
                            array_push($tutorArray[$key]['items'], $items->class_id);
                            $flag = 0;
                        }
                    }
                    if ($flag) {
                        $tutorArray[] = ["tutor_id" => $items->classWebinar->tutor_id, 'items' => [$items->class_id]];
                    }
                }
            }       
           
            //mail send
            foreach ($tutorArray as $key => $val) {
                $transactionItems = $transaction->transactionItems->whereIn('class_id', $val["items"]);
                $this->transactionRepository->getTransaction($params);
                if (!empty($transactionItems)) {
                    // send notification tutor
                    $classDetails = '';
                    foreach ($transactionItems as $booking) {
                        $classDetails .= $booking->classWebinar->class_name.'('.$booking->classWebinar->class_type.')-'.
                            convertDateToTz(
                                $booking->classWebinar->start_time,
                                'UTC',
                                'h:i A',
                                $booking->classWebinar->tutor->time_zone
                            ).
                            ' for'.getDuration($booking->classWebinar->duration).',';
                        $student_id = $booking->student_id;
                        $student_name =  $booking->student->name;
                        $tutor_id =  $booking->classWebinar->tutor->id;
                        $tutor_email =  $booking->classWebinar->tutor->email;
                        $tutor_name =  $booking->classWebinar->tutor->name;
                    }

                    $notificationData = [
                        'from_id' =>  $student_id,
                        'to_id' => $tutor_id,
                        'type' => 'tutor_class_webinar_booked',
                        'notification_message' =>  trans(
                            "message.tutor_booking_class_webinar_notification",
                            [
                                "studentName" => $student_name,
                                "classDetails" => $classDetails
                            ]
                        ),
                        "extra_data" => [
                            'type' => 'tutor_class_webinar_booked',
                        ],                   
                    ];
                    $this->notificationRepository
                        ->sendNotification($notificationData, true);

                    $emailTemplate = new TutorScheduleClassWebinarBook($transactionItems, $student_name, $tutor_name);
                    sendMail($tutor_email, $emailTemplate);
                }
                
            }
           
        }
        
    }

    /**
     * Method classFullBooking
     * 
     * @param object $bookings 
     * 
     * @return void
     */
    public function classFullBooking(object $bookings)
    {
         //mail send
         $emailTemplate = new TutorScheduleClass($bookings);
         sendMail($bookings[0]->class->tutor->email, $emailTemplate);
    }

}
