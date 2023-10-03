<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClassBooking;
use App\Models\ClassWebinar;
use Carbon\Carbon;
use App\Jobs\ClassReminderJob;
use Illuminate\Support\Facades\Log;
class ClassReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:class-start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder to the student 
    (15 minutes before the scheduled class)';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentTime = Carbon::now()->addMinute(15)->format('Y-m-d H:i');
        
        ClassWebinar::where('start_time', $currentTime)
            ->with(
                [
                    "bookings" =>
                    function ($q) {
                        $q->where("status", '=', ClassBooking::STATUS_CONFIRMED);
                    }
                ]
            )->chunk(
                10, 
                function ($classes) {
                    Log::channel('cron')
                        ->info(
                            "Class start reminder before 15 min",
                            ["classes" => $classes->pluck('id')]
                        );
                        
                    foreach ($classes as $class) {
                        foreach ($class->bookings as $booking) {
                            ClassReminderJob::
                            dispatch(
                                $booking->student->id,
                                $booking->student->language,
                                $booking
                            );
                        }
                    }
                   
                }
            );
      
    }
}
