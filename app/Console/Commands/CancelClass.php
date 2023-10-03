<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClassWebinar;
use App\Models\User;
use Carbon\Carbon;
use App\Repositories\ClassRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\Log;
class CancelClass extends Command
{
    protected $classRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change class status from active to Cancel.';

    /**
     * Method __construct
     *
     * @param Application     $app 
     * @param ClassRepository $classRepository 
     * 
     * @return void
     */
    public function __construct( 
        Application $app,
        ClassRepository $classRepository
    ) {
        parent::__construct($app);
        $this->classRepository = $classRepository;
    }

    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentTime = Carbon::now()->format('Y-m-d H:i:s');
        
        ClassWebinar::where('end_time', '<', $currentTime)
            ->where('status', '!=', ClassWebinar::STATUS_CANCELLED)
            ->where('is_started', '<>', 1)
            ->chunk(
                10, function ($classes) {
                   
                    Log::channel('cron')
                        ->info(
                            "Class cancelled", 
                            ["class_id" => $classes->pluck('id')]
                        );
                        
                    foreach ($classes as $class) {
                        $data["class_id"] = $class->id;
                        $data['user_id'] = $class->tutor_id;
                        $data['user_type'] = User::TYPE_TUTOR;
                        $data['is_system'] = true;
                        //$this->classRepository->cancelClass($data);
                        $this->classRepository->autoCancelClass($data);
                    }
                } 
            );
        
    }
}
