<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TutorClassRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            // 'class_type' => $this->class_type,
            'preferred_gender' => $this->classrequest->preferred_gender,
            'class_duration' => $this->classrequest->class_duration,
            // 'class_time' => $this->class_time,
            // 'start_time' => $this->classrequest->start_time,
            // 'end_time' => $this->classrequest->end_time,
            // // 'request_time' => $this->request_time,
            // // 'expired_time' => $this->expired_time,
            'status' => $this->status,
            'class_level' => UserLevelResource::make($this->classrequest->levels),
            'class_grade' => UserGradeResource::make($this->classrequest->grades),
            'class_subject' => UserSubjectResource::make($this->classrequest->subjects),
            'categories' => UserLevelResource::make($this->classrequest->categories),
            'scheduled_class_date' => ClassRequestDetailResource::collection($this->classrequest->classRequestDetails),
            'tutor_quote' => $this->tutor_quote,
            'tutor_id' => $this->tutor_id,
            'class_request_id' => $this->class_request_id,
            'user_id' => $this->user_id,
            // $this->mergeWhen(
            //     $this->tutor_quote,
            //     [
            //         'tutor_quote' => $this->tutor_quote,
            //     ]
            // ),
            'student_data' => UserResource::make($this->userdata),
        ];
    }
}
