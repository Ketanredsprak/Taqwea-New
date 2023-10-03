<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class giveFeedbackResource extends JsonResource
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
            'student_id' => $this->student_id,
            'class_id' => $this->class_id,
            "name" => $this->when(
                $this->student,
                function () {
                    return $this->student->translateOrDefault()->name;
                }
            ),
            "profile_image_url" => $this->when(
                $this->student,
                function () {
                    return $this->student->profile_image_url;
                }
            ),
            "rating" => $this->when(
                $this->rating,
                function () {
                    return new RatingReviewResource($this->rating);
                }
            ),
        ];
    }
}
