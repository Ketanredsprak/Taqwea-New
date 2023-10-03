<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaiseHandResource extends JsonResource
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
            'status' => $this->status,
            'student' => $this->when(
                $this->student,
                function () {
                    return [
                        'id' => $this->student->id,
                        'name' => $this->student->translateOrDefault()->name,
                        'profile_image_url' => $this->student->profile_image_url
                    ];
                }
            )
        ];
    }
}
