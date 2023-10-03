<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * ClassTodaySchedule Mail
 */
class ClassTodaySchedule extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $classes;

    public $timeZone;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(object $data, $timeZone)
    {
        $this->classes = $data;
        $this->timeZone = $timeZone;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('message.class_today_schedule'))
            ->view('email.class-today-schedule');
    }
}
