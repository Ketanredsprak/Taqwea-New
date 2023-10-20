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


        
        if ($this->class_duration / 60 == 0.5) {
            $class_duration_hour = "0 hr 30 m";
        } else if ($this->class_duration / 60 == 1) {
            $class_duration_hour = "1 hr 00 m";
        } else if ($this->class_duration / 60 == 1.5) {
            $class_duration_hour = "1 hr 30 m";
        } else if ($this->class_duration / 60 == 2) {
            $class_duration_hour = "2 hr 00 m";
        } else if ($this->class_duration / 60 == 2.5) {
            $class_duration_hour = "2 hr 30 m";
        } else if ($this->class_duration / 60 == 3) {
            $class_duration_hour = "3 hr 00 m";
        } else if ($this->class_duration / 60 == 3.5) {
            $class_duration_hour = "3 hr 30 m";
        } else if ($this->class_duration / 60 == 4) {
            $class_duration_hour = "4 hr 00 m";
        } else if ($this->class_duration / 60 == 4.5) {
            $class_duration_hour = "4 hr 30 m";
        } else if ($this->class_duration / 60 == 5) {
            $class_duration_hour = "5 hr 00 m";
        } else if ($this->class_duration / 60 == 5.5) {
            $class_duration_hour = "5 hr 30 m";
        } else if ($this->class_duration / 60 == 6) {
            $class_duration_hour = "6 hr 00 m";
        } else if ($this->class_duration / 60 == 6.5) {
            $class_duration_hour = "6 hr 30 m";
        } else if ($this->class_duration / 60 == 7) {
            $class_duration_hour = "7 hr 00 m";
        } else if ($this->class_duration / 60 == 7.5) {
            $class_duration_hour = "7 hr 30 m";
        } else {
            $class_duration_hour = $this->class_duration;
        }


    

        return [

            'id' => $this->id,

            // 'user' => $this->user_id,
            'note' => $this->note,

            'class_type' => $this->class_type,

            'preferred_gender' => $this->preferred_gender,

            'class_duration' => $this->class_duration,

            'class_duration_hr' => $class_duration_hour,

            'class_time' => $this->class_time,

            'start_time' => $this->start_time,

            'end_time' => $this->end_time,

            'status' => $this->status,

            'class_level' => UserLevelResource::make($this->levels),
            
            'class_grade' => UserGradeResource::make($this->grades),
            
            'class_subject' => UserSubjectResource::make($this->subjects),
            
            'categories' => UserLevelResource::make($this->categories),
            
            'scheduled_class_date' => ClassRequestDetailResource::collection($this->classRequestDetails),
            
            'number_of_classes' => count(ClassRequestDetailResource::collection($this->classRequestDetails)),
            
            'request_valide_timer' => $this->timer,

        ];

    }

}

