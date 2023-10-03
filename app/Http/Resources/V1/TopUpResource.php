<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TopUpResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request 
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
            'class_hours_price' => $this->class_per_hours_price,
            'webinar_hours_price' => $this->webinar_per_hours_price,
            'blog_price' => $this->blog_per_hours_price,
            'is_featured_price' => $this->blog_per_hours_price,
        ];
    }
}
