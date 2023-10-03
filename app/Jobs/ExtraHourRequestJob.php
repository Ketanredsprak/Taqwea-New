<?php

namespace App\Jobs;

use App\Repositories\ExtraHourRequestRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
class ExtraHourRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    
    /**
     * Create a new job instance.
     * 
     * @param array $data 
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     * 
     * @param ExtraHourRequestRepository $extraHourRequestRepository 
     *
     * @return void
     */
    public function handle(ExtraHourRequestRepository $extraHourRequestRepository)
    {
        Log::channel('job')
            ->info(
                "Extra hours request", 
                ["data" => $this->data]
            );
        $extraHourRequestRepository->createRequest($this->data);
    }
}
