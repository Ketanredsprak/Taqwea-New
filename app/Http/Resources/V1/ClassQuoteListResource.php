<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ClassQuoteListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'class_request_id' => $this->class_request_id,
            'tutor_id' => $this->tutor_id,
            'status' => $this->status,
            'price' => $this->price,
            'tutor_note' => $this->note,
            'quote_submit_time' => $this->created_at,
            'tutor_data' => UserBasicInfoResource::make($this->tutor),
            'class_request_data' => ClassRequestResource::make($this->class_request),
            
            
        ];
    }
}
