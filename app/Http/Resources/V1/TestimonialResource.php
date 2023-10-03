<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * TestimonialResource
 */
class TestimonialResource extends JsonResource
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
            'id' => $this->id ?? $this->testimonial_id,
            'name' => $this->translateOrDefault()->name,
            'testimonial_image_url' => $this->testimonial_image_url,
            'rating' => $this->rating,
            'content' => $this->translateOrDefault()->content,
        ];
    }
}
