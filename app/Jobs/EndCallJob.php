<?php

namespace App\Jobs;

use App\Repositories\ClassBookingRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class EndCallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        array $data
    )
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ClassBookingRepository $classBookingRepository)
    {
        Log::channel('job')
            ->info(
                "Call end", 
                ["data" => $this->data]
            );
        $this->classBookingRepository = $classBookingRepository;
        $this->classBookingRepository->completeBooking($this->data);
    }
}
