<?php

namespace App\Jobs;

use App\Repositories\ClassBookingRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class CancelBookingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    protected $classBookingRepository;

    /**
     * Create a new job instance.
     *
     * @param array $data 
     * 
     * @return void
     */
    public function __construct(
        array $data
    ) {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param ClassBookingRepository $classBookingRepository 
     * 
     * @return void
     */
    public function handle(ClassBookingRepository $classBookingRepository)
    {
        Log::channel('job')
            ->info(
                "Class cancelled", 
                ["data" => $this->data]
            );

        $this->classBookingRepository = $classBookingRepository;
        $this->data['is_system'] = true;
        $this->classBookingRepository->cancelBooking($this->data);
    }
}