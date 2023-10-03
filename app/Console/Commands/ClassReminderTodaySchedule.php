<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ClassBooking;
use App\Models\ClassWebinar;
use Carbon\Carbon;
use App\Mail\ClassTodaySchedule;
use Illuminate\Support\Facades\Log;
class ClassReminderTodaySchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:class-reminder-today-schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The reminder will have the list of classes 
        that are scheduled today.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentTime = Carbon::now()->addHours(2)->format('Y-m-d H:i');
        ClassWebinar::where('start_time', $currentTime)
            ->where('status', ClassWebinar::STATUS_ACTIVE)
            ->chunk(
                10, 
                function ($classes) use ($currentTime) {
                    foreach ($classes as $class) {
                        $this->getTutorTodaySchedules(
                            $class->tutor->time_zone,
                            $class->tutor->id,
                            $currentTime
                        );
                    }
                }
            );
    }

    /**
     * Method getTutorTodaySchedules
     * 
     * @param string $timeZone 
     * @param int    $tutorId  
     * @param date   $currentTime  
     * 
     * @return void
     */
    public function getTutorTodaySchedules($timeZone, int $tutorId, $currentTime)
    {
        $userCurrentDate = Carbon::now($timeZone)
        ->format("Y-m-d");

        $timeZoneDiff = Carbon::createFromTimestamp(0, $timeZone)
            ->getOffsetString();

        $classes = ClassWebinar::whereRaw(
            "DATE(
                CONVERT_TZ(
                    start_time, '+00:00', '" . $timeZoneDiff . "')
                ) = '" .$userCurrentDate . "'"
        )->where("tutor_id", $tutorId)
            ->where('status', ClassWebinar::STATUS_ACTIVE)
            ->get();
           
        /**
         * Check tutor first schedule
         */
        if (!empty($classes)) {
            Log::channel('cron')
                ->info(
                    "Todays schedule classes",
                    ["classes" => $classes->pluck('id')]
                );
            $firstSchedule = ClassWebinar::whereIn("id", $classes->pluck('id'))
            ->where('start_time', '<', $currentTime)
            ->where('status', ClassWebinar::STATUS_ACTIVE)
            ->first();
            if (!$firstSchedule) {

                $emailTemplate = new ClassTodaySchedule($classes, $timeZone);
                sendMail($classes[0]->tutor->email, $emailTemplate);
            }
        }
        
    }
}
