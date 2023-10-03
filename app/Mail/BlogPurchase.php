<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BlogPurchase extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $transaction;
    /**
     * Create a new message instance.
     *
     * @param object $data 
     * 
     * @return void
     */
    public function __construct(object $data)
    {
        $this->transaction = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('message.blog_purchase_subject'))
            ->view('email.blog-purchase');
        
    }
}
