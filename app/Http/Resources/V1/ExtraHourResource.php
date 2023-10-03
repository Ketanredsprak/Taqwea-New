<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExtraHourResource extends JsonResource
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
        if (is_null($this->resource)) {
            return [];
        }
        return [
            'id' => $this->id,
            'status' => $this->status,
            'student' => $this->when(
                $this->student,
                function () {
                    return [
                        'id' => $this->student->id,
                        'name' => $this->student->translateOrDefault()->name,
                        'profile_image_url' => $this->student->profile_image_url
                    ];
                }
            ),
            'class_id' => $this->class ? $this->class->id : null,
            'tutor_name' => $this->class ? $this->class->tutor->name : '',
            'extra_hour_charge' => $this->class ? $this->class->extra_hour_charge : '',
            'extra_duration' => $this->class ? $this->class->extra_duration : '',
        ];
    }
}
