<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassRequestResource extends JsonResource
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
            // 'user' => $this->user_id,
            'class_type' => $this->class_type,
            'preferred_gender' => $this->preferred_gender,
            'class_duration' => $this->class_duration,
            'class_time' => $this->class_time,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            // 'request_time' => $this->request_time,
            // 'expired_time' => $this->expired_time,
            'status' => $this->status,
            'class_level' => UserLevelResource::make($this->levels),
            'class_grade' => UserGradeResource::make($this->grades),
            'class_subject' => UserSubjectResource::make($this->subjects),
            'categories' => UserLevelResource::make($this->categories),
            'scheduled_class_date' => ClassRequestDetailResource::collection($this->classRequestDetails),
        ];
    }
}
