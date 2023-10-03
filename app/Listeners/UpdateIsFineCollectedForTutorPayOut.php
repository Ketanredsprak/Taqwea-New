<?php

namespace App\Listeners;

use App\Events\UpdateIsFineCollectedForTutorPayOutEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\TransactionRepository;
use App\Models\Transaction;



/**
 * Listener UpdateIsFineCollectedForTutorPayOut 
 */
class UpdateIsFineCollectedForTutorPayOut implements ShouldQueue
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
     * @param UpdateIsFineCollectedForTutorPayOutEvent $event 
     * 
     * @return void
     */
    public function handle(UpdateIsFineCollectedForTutorPayOutEvent $event)
    {
        $tutor_id = $event->data['tutor_id'];
        // update the transaction with is_fine_collected to 1 for not deducting again 
        
        Transaction::where(
            [
                ['user_id', $tutor_id],
                ['is_fine_collected', 0],
                ['transaction_type', Transaction::STATUS_FINE],
            ]
        )
        ->update(['is_fine_collected' => 1]);
        
    }
}
