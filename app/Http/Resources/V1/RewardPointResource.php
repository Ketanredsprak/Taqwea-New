<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\RewardPoint;

class RewardPointResource extends JsonResource
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
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'points' => $this->points,
            'type' => $this->type,
            'availablePoint' => RewardPoint::getUserPoints($this->user_id)            
        ];
    }
}
