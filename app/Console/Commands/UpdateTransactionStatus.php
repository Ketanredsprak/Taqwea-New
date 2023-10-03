<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClassBooking;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
class UpdateTransactionStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:transaction-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update pending status to failed';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::channel('cron')->info("Update payment status");
        $currentTime = Carbon::now()->subMinute(30)->format('Y-m-d H:i:s');
        Transaction::where('created_at', '<', $currentTime)
            ->where("status", Transaction::STATUS_PENDING)
            ->update(["status" => Transaction::STATUS_FAILED]);
        
        TransactionItem::where('created_at', '<', $currentTime)
            ->where("status", TransactionItem::STATUS_PENDING)
            ->update(["status" => TransactionItem::STATUS_FAILED]);
    }
}
