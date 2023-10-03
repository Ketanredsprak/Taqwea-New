<?php

namespace App\Http\Resources\V1;

use App\Models\RatingReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassBookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'booking_date' => $this->created_at,
            'class_id' => $this->class_id,
            'cancelled_by' => ($this->cancelledBy)
                ? $this->cancelledBy->user_type : '',
            'is_joined' => $this->is_joined,
            'is_live' => $this->is_live,
            'class' => $this->when(
                $this->class,
                [
                    'id' => $this->class->id,
                    'class_name' => $this->class->translateOrDefault()->class_name,
                    'class_type' => $this->class->class_type,
                    'class_image_url' => $this->class->class_image_url,
                    'duration' => $this->class->duration,
                    'hourly_fees' => $this->class->hourly_fees,
                    'total_fees' => $this->class->total_fees,
                    'start_time' => $this->class->start_time,
                    'end_time' => $this->class->end_time,
                    'no_of_attendee' => $this->class->no_of_attendee,
                    'subject' => $this->when(
                        $this->class->subject,
                        function () {
                            return [
                                'id' => $this->class->subject->id,
                                'name' =>  $this->class->subject
                                    ->translateOrDefault()->subject_name
                            ];
                        }
                    ),
                ]
            ),
            'student_count' => count($this->class->bookings),
            'transaction_items' => $this->when(
                $this->transactionItem,
                [
                    'total_amount' => $this->transactionItem->total_amount,
                ]
            ),
            'student' => $this->when(
                $this->student,
                [
                    'id' => $this->student->id,
                    'name' => $this->student->translateOrDefault()->name,
                    'rating' => RatingReview::getAverageRating(
                        $this->student->id,
                        $this->class->id
                    ),
                    'profile_image_url' => $this->student->profile_image_url,
                    'email' => $this->student->email
                ]
            ),
            'tutor' => $this->when(
                $this->class && $this->class->tutor()->withTrashed(),
                [
                    'id' => $this->class->tutor()->withTrashed()->getResults()->id,
                    'name' => $this->class->tutor()->withTrashed()->getResults()->translateOrDefault()->name,
                    'profile_image_url' => $this->class->tutor()->withTrashed()->getResults()->profile_image_url,
                ]
            )
        ];
    }
}
