<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TutorScheduleClassWebinarBook extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $bookings;
    public $student_name;
    public $tutor_name;

    /**
     * Create a new message instance.
     *
     * @param object $data 
     * 
     * @return void
     */
    public function __construct(object $data, $student_name, $tutor_name)
    {
        $this->bookings = $data;
        $this->student_name = $student_name;
        $this->tutor_name = $tutor_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('message.student_booked_class_webinar', ["type" => 'class/webinar']))
            ->view('email.tutor-schedule-class-webinar-book');
    }
}
