<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class GlobalSearchResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->translateOrDefault()->class_name
        ];
    }
}
