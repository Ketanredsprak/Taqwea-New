<?php

namespace App\Jobs;

use App\Models\ClassWebinar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Log;
/**
 * Class ClassReminderJob
 */
class ClassReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $to_id;

    protected $user_language;

    protected $booking;

    protected $notificationRepository;

    /**
     * Create a new job instance.
     *
     * @param int    $to_id  
     * @param string $language   
     * @param object $booking     
     * 
     * @return void
     */
    public function __construct(int $to_id, $language, $booking)
    {
        $this->to_id = $to_id;
        $this->user_language = $language;
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     *
     * @param NotificationRepository $notificationRepository 
     * 
     * @return void
     */
    public function handle(NotificationRepository $notificationRepository)
    {
        Log::channel('job')
            ->info(
                "Reminder before 15 min start class", 
                ["class_id" => $this->booking]
            );
        $this->notificationRepository = $notificationRepository;
        $this->student();
        $this->tutor();
    }

    /**
     * Method student
     * 
     * @return void
     */
    public function student()
    {
        $type = ($this->booking->class->class_type == ClassWebinar::TYPE_CLASS)?
            'student_send_class_reminder':'student_send_webinar_reminder';
        $reminder_type = ($this->booking->class->class_type == ClassWebinar::TYPE_CLASS)?
            'class_reminder':'webinar_reminder';
        
        $url = ($this->booking->class->class_type == ClassWebinar::TYPE_CLASS)?
        route('classes/show', ["class" => $this->booking->class->slug]):
        route('webinars/show', ["class" => $this->booking->class->slug]);
            
        //setUserLanguage($this->user_language);
        $notificationData = [
            'from_id' =>  $this->booking->class->tutor->id,
            'to_id' => $this->to_id,
            'type' => $type,
            'notification_message' =>  trans(
                "message.class_start_notification",
                [
                    "type" => $this->booking->class->class_type == 'class'? trans('labels.class') : trans('labels.webinar'),
                    "className"=> $this->booking->class->class_name
                ]
            ),
            "extra_data" => [
                'type' => $reminder_type,
                'id' =>  $this->booking->class->id,
                'slug' =>  $this->booking->class->slug,
                'url' => $url
            ],                   
        ];
        $this->notificationRepository
            ->sendNotification($notificationData, true);
    }

    /**
     * Method tutor
     * 
     * @return void
     */
    public function tutor()
    {
        $type = ($this->booking->class->class_type == ClassWebinar::TYPE_CLASS)?
            'tutor_send_class_reminder':'tutor_send_webinar_reminder';
        $url = ($this->booking->class->class_type == ClassWebinar::TYPE_CLASS)?
            route('tutor.classes.detail', ["slug" => $this->booking->class->slug]):
            route('tutor.webinars.detail', ["slug" => $this->booking->class->slug]);
        $reminder_type = ($this->booking->class->class_type == ClassWebinar::TYPE_CLASS)?
            'tutor_class_reminder':'tutor_webinar_reminder';
            
        //setUserLanguage($this->booking->class->tutor->language);
        $notificationData = [
            'from_id' => $this->to_id,
            'to_id' => $this->booking->class->tutor->id,
            'type' => $type,
            'notification_message' =>  trans(
                "message.tutor_class_start_notification",
                [
                    "type" => $this->booking->class->class_type == 'class'? trans('labels.class') : trans('labels.webinar'),
                    "className"=> $this->booking->class->class_name,
                    "startTime" => convertDateToTz(
                        $this->booking->class->start_time,
                        'UTC',
                        'h:s A',
                        $this->booking->class->tutor->time_zone
                    ),
                    "endTime" => getDuration($this->booking->class->duration)
                ]
            ),
            "extra_data" => [
                'type' => $reminder_type,
                'id' =>  $this->booking->class->id,
                'slug' =>  $this->booking->class->slug,
                'url' => $url
            ],                   
        ];
        $this->notificationRepository
            ->sendNotification($notificationData, true);
    }
}
