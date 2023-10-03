<?php

namespace App\Jobs;

use App\Models\Thread;
use App\Models\ClassBooking;
use App\Models\ClassWebinar;
use Illuminate\Bus\Queueable;
use App\Repositories\ClassRepository;
use App\Repositories\ThreadRepository;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ThreadCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $classId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        int $classId
    ) {
        $this->classId = $classId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(ClassRepository $classRepository, ThreadRepository $threadRepository)
    {
        Log::channel('job')
            ->info(
                "chat thread", 
                ["class_id" => $this->classId]
            );
        $this->classRepository = $classRepository;
        $this->threadRepository = $threadRepository;
        $class = $this->classRepository->where(
            [
                'id' => $this->classId,
                'status' => ClassWebinar::STATUS_COMPLETED
            ]
        )->with(
            [
                "bookings" =>
                function ($q) {
                    $q->whereNull("parent_id");
                    $q->where("status", '!=', ClassBooking::STATUS_CANCELLED);
                }
            ]
        )->first();
        if ($class) {
            $classBookings = $class->bookings;
            if (count($classBookings) > 0) {
                foreach ($classBookings as $booking) {
                    if (in_array(
                        $booking->status,
                        [ ClassBooking::STATUS_CONFIRMED, ClassBooking::STATUS_COMPLETED ]
                    )
                    ) {
                        $where = [
                            'class_id'=>$booking->class_id,
                            'student_id'=>$booking->student_id,
                            'tutor_id'=>$class->tutor_id,
                            'booking_id'=>$booking->id,
                        ];
                        $data = [
                            'uuid'=>Thread::generateUUID(),
                            'class_id'=>$booking->class_id,
                            'student_id'=>$booking->student_id,
                            'tutor_id'=>$class->tutor_id,
                            'booking_id'=>$booking->id,
                        ];
                        if ($this->threadRepository->checkIfExist($where) == 0) {
                            $this->threadRepository->createThread($data);
                        }
                    }
                }
            }
        }
    }
}
