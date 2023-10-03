<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * StudentBookedClassWebinar
 */
class StudentBookedClassWebinar extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transactionItem;

    /**
     * Create a new message instance.
     *
     * @param object $transactionItem 
     * 
     * @return void
     */
    public function __construct(object $transactionItem)
    {
        $this->transactionItem = $transactionItem;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(
            trans(
                'message.student_booked_class_webinar',
                [
                    'type' => @$this->transactionItem->classWebinar->class_type
                ]
            )
        )->view('email.student-booked-class');
    }
}
