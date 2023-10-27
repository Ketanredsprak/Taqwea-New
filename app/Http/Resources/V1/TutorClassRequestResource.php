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


       
        if ($this->classrequest->class_duration / 60 == 0.5) {
            $class_duration_hour = "0 hr 30 m";
        } else if ($this->classrequest->class_duration / 60 == 1) {
            $class_duration_hour = "1 hr 00 m";
        } else if ($this->classrequest->class_duration / 60 == 1.5) {
            $class_duration_hour = "1 hr 30 m";
        } else if ($this->classrequest->class_duration / 60 == 2) {
            $class_duration_hour = "2 hr 00 m";
        } else if ($this->classrequest->class_duration / 60 == 2.5) {
            $class_duration_hour = "2 hr 30 m";
        } else if ($this->classrequest->class_duration / 60 == 3) {
            $class_duration_hour = "3 hr 00 m";
        } else if ($this->classrequest->class_duration / 60 == 3.5) {
            $class_duration_hour = "3 hr 30 m";
        } else if ($this->classrequest->class_duration / 60 == 4) {
            $class_duration_hour = "4 hr 00 m";
        } else if ($this->classrequest->class_duration / 60 == 4.5) {
            $class_duration_hour = "4 hr 30 m";
        } else if ($this->classrequest->class_duration / 60 == 5) {
            $class_duration_hour = "5 hr 00 m";
        } else if ($this->classrequest->class_duration / 60 == 5.5) {
            $class_duration_hour = "5 hr 30 m";
        } else if ($this->classrequest->class_duration / 60 == 6) {
            $class_duration_hour = "6 hr 00 m";
        } else if ($this->classrequest->class_duration / 60 == 6.5) {
            $class_duration_hour = "6 hr 30 m";
        } else if ($this->classrequest->class_duration / 60 == 7) {
            $class_duration_hour = "7 hr 00 m";
        } else if ($this->classrequest->class_duration / 60 == 7.5) {
            $class_duration_hour = "7 hr 30 m";
        } else {
            $class_duration_hour = $this->classrequest->class_duration;
        }

   


        return [

            'id' => $this->id,

            'note' => $this->classrequest->note,

            'preferred_gender' => $this->classrequest->preferred_gender,

            'class_duration' => $this->classrequest->class_duration,

            'class_duration_hour' => $class_duration_hour,

            'class_time' => $this->classrequest->class_time,

            'class' => count($this->classrequest->classRequestDetails),

            'status' => $this->status,

            'class_level' => UserLevelResource::make($this->classrequest->levels),

            'class_grade' => UserGradeResource::make($this->classrequest->grades),

            'class_subject' => UserSubjectResource::make($this->classrequest->subjects),

            'categories' => UserLevelResource::make($this->classrequest->categories),

            'scheduled_class_date' => ClassRequestDetailResource::collection($this->classrequest->classRequestDetails),
 
            'tutor_id' => $this->tutor_id,

            'class_request_id' => $this->class_request_id,

            'user_id' => $this->user_id,

            'student_data' => UserResource::make($this->userdata), 

            'is_quote_sent' => $this->is_quote_sent,

            'create_date_time' => $this->classrequest->created_at,

            // 'tutot_quote_data' => $this->when(
            //     $this->is_quote_sent == 1,
            //     function () {
            //         return $this->tutot_quote_data;
            //     }
            // ),


        ];

    }

}
