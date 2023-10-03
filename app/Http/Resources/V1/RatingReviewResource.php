<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
class RatingReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param $request 
     * 
     * @return array
     */
    public function toArray($request)
    {
        return [
            'rating' => $this->rating,
            'review' => $this->review,
            'clarity' => $this->clarity,
            'orgnization' => $this->orgnization,
            'give_homework' => $this->give_homework,
            'use_of_supporting_tools' => $this->use_of_supporting_tools,
            'on_time' => $this->on_time,
            'from' => $this->when(
                $this->from,
                function () {
                    return [
                        'id' => $this->from->id,
                        'name' => $this->from->translateOrDefault()->name,
                        'email' => $this->from->email,
                        'profile_image_url' => $this->from->profile_image_url,
                    ];
                }
            ),
            'to' => $this->when(
                $this->to,
                function () {
                    return [
                        'id' => $this->to->id,
                        'name' => $this->to->translateOrDefault()->name,
                        'email' => $this->to->email,
                        'profile_image_url' => $this->to->profile_image_url,
                    ];
                }
            ),
            'class' => $this->when(
                $this->class,
                function () {
                    return [
                        'id' => $this->class->id,
                        'name' => $this->class->translateOrDefault()->class_name,
                    ];
                }
            ),
            'created_at' => $this->created_at
        ];
    }
}
