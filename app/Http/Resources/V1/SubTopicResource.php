<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SubTopicResource extends JsonResource
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
            'sub_topic' => ($this->sub_topic)
                ?$this->sub_topic:$this->{'sub_topic:ar'},
            'translations' => $this->translations
        ];
    }
}
