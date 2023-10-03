<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TutorActivePlanResource extends JsonResource
{
    /**
     * Tutor active plan the resource into an array.
     *
     * @param Request $request 
     * 
     * @return array
     */
    public function toArray($request)
    {
        return [
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'class_remaining_hours' => $this->tutor->tutor->class_hours,
            'webinar_remaining_hours' => $this->tutor->tutor->webinar_hours,
            'blog_remaining' => $this->tutor->tutor->blog,
            'featured_expary' => $this->When(
                $this->tutor->tutor->is_featured,
                function () {
                    return $this->tutor->tutor->is_featured_end_date;
                }
            )
        ];
    }
}
