<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TutorCertificateResource extends JsonResource
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
            'certificate_name' => $this->translateOrDefault()->certificate_name,
            'certificate_url' => $this->certificateUrl,
            'certificate_type' => $this->certificateType,
            'certificate_thumb' => $this->certificateThumb,
        ];
    }
}
