<?php

namespace App\Listeners;

use App\Events\TutorFineEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\TransactionRepository;



/**
 * Listener NotifyTutorFine 
 */
class NotifyTutorFine implements ShouldQueue
{
    protected $transactionRepository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Handle the event.
     *
     * @param TutorFineEvent $event 
     * 
     * @return void
     */
    public function handle(TutorFineEvent $event)
    {
        $data = $event->data;
        $this->transactionRepository->createTransaction($data);
    }
}
