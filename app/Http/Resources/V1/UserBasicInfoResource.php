<?php

namespace App\Http\Resources\V1;

use App\Models\RatingReview;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBasicInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'profile_image_url' => $this->profile_image_url,
                'bio' => $this->bio ?? '',
                'rating' => RatingReview::getAverageRating($this->id),
        ];
    }
}
