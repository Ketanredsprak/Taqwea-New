<?php

namespace App\Listeners;

use App\Events\BookingEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\TransactionRepository;
use App\Repositories\NotificationRepository;
use App\Mail\BlogPurchase;
use App\Mail\ClassBlogBooking;
use App\Mail\ClassWebinarBooking;
use App\Mail\StudentBookedClassWebinar;
use App\Models\ClassWebinar;
class NotifyBooking implements ShouldQueue
{
    protected $transactionRepository;

    protected $notificationRepository;

    /**
     * Create a instance.
     *
     * @param TransactionRepository  $transactionRepository 
     * @param NotificationRepository $notificationRepository 
     * 
     * @return void
     */
    public function __construct(
        TransactionRepository $transactionRepository,
        NotificationRepository $notificationRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->notificationRepository = $notificationRepository;
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
            && $transaction->transactionItems[0]->blog_id
        ) {
            // mail send
            $emailTemplate = new BlogPurchase($transaction);
            sendMail($transaction->user->email, $emailTemplate);
        } else if ($transaction 
            && !empty($transaction->transactionItems)
            && count($transaction->transactionItems) === 1
            && $transaction->transactionItems[0]->class_id
        ) {
            // mail send
            $emailTemplate = new ClassWebinarBooking($transaction);
            sendMail($transaction->user->email, $emailTemplate);

        } else if ($transaction 
            && !empty($transaction->transactionItems)
            && count($transaction->transactionItems) > 1
        ) {
            //mail send
            $emailTemplate = new ClassBlogBooking($transaction);
            sendMail($transaction->user->email, $emailTemplate);
        }
        
    }
}
