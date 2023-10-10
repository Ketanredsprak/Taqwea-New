<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
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
            'price' => $this->price,
            'status' => $this->status,
            'class_request_data' =>  $this->class_request_id,
            'tutor_data' => [
                        'tutor_id' => $this->tutor->id,
                        'tutor_email' => $this->tutor->email,
                 ],  
                  
        ];
    }
}
