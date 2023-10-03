<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * PlanUpgrade
 */
class PlanUpgrade extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * Create a new message instance.
     * 
     * @param object $data 
     *
     * @return void
     */
    public function __construct(object $data)
    {
        $this->user = $data;
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
                'message.subscribed_to_plan',
                ['plan_name' => @$this->user->subscription->subscription_name]
            )
        )
            ->view('email.subscription-plan-upgrade');
    }
}
