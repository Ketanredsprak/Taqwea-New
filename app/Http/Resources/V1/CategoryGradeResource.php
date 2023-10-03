<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryGradeResource extends JsonResource
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
            'id' => $this->grade->id,
            'text' => $this->grade->translateOrDefault()->grade_name,
            "class_count" => $this->class_count ?? 0,
            "webinar_count" => $this->webinar_count ?? 0,
            "tutor_count" => $this->tutor_count ?? 0,
            "subject_count" => $this->subject_count ?? 0,
        ];
    }
}
