<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorResource extends JsonResource
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
            'experience' => $this->experience,
            'introduction_video_url' => $this->introduction_video_url,
            'introduction_video' => $this->introduction_video,
            'introduction_video_thumb' => $this->introduction_video_thumb,
            'id_card_url' => $this->id_card_url,
            'beneficiary_name' => $this->beneficiary_name,
            'account_number' => $this->account_number,
            'bank_code' => $this->bank_code,
            'address' => $this->address,
        ];
    }
}
