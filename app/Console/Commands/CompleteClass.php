<?php

namespace App\Console\Commands;

use App\Models\ClassBooking;
use App\Models\ClassWebinar;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Events\ClassCompletedEvent;
use Illuminate\Support\Facades\Log;
class CompleteClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete:class';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change class status from active to complete.';

   

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentTime = Carbon::now()->format('Y-m-d H:i');

        $classes = ClassWebinar::where('end_time', '<', $currentTime)
            ->where('status', '!=', ClassWebinar::STATUS_CANCELLED)
            ->where('is_started', 1)
            ->pluck('id')
            ->toArray();
            
        Log::channel('cron')
            ->info(
                "Class completed", 
                ["class_id" => $classes]
            );
            
        foreach ($classes as $value) {
            $wClass = ClassWebinar::find($value);
            $wClass->status = ClassWebinar::STATUS_COMPLETED;
            $wClass->save();
            $classBookings = $wClass->bookings;
            if (count($classBookings) > 0) {
                foreach ($classBookings as $booking) {
                    if (in_array(
                        $booking->status,
                        [
                            ClassBooking::STATUS_CONFIRMED
                        ]
                    )
                    ) {
                        $data = [
                            'booking_id' => $booking->id
                        ];
                        ClassCompletedEvent::dispatch($data);
                    }
                }
            }
        }

        
        ClassBooking::whereIn('class_id', $classes)
            ->where("status", ClassBooking::STATUS_CONFIRMED)
            ->update(['status' => ClassBooking::STATUS_COMPLETED]);
    }
}
