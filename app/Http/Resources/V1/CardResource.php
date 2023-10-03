<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
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
            "id" => $this->id,
            "card_id" => $this->card_id,
            "card_number" => $this->card_number,
            "expiry_month" => $this->exp_month,
            "expiry_year" => $this->exp_year,
            "card_holder_name" => $this->card_holder_name,
            "card_type" => $this->brand,
        ];
    }
}
