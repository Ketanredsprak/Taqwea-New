<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * TutorScheduleClass
 */
class TutorScheduleClass extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $bookings;

    /**
     * Create a new message instance.
     *
     * @param object $data 
     * 
     * @return void
     */
    public function __construct(object $data)
    {
        $this->bookings = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('message.tutor_schedule_class'))
            ->view('email.tutor-schedule-class');
    }
}
