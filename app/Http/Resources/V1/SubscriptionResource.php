<?php

namespace App\Http\Resources\V1;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * SubscriptionResource
 */
class SubscriptionResource extends JsonResource
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
        /**
         * User
         * 
         * @var $loggedInUser User 
         **/
        return [
            'id' => $this->id,
            'name' => $this->subscription_name,
            'description' => $this->subscription_description,
            'allow_booking' => $this->allow_booking,
            'class_hours' => $this->class_hours,
            'webinar_hours' => $this->webinar_hours,
            'featured' => $this->featured,
            'commission' => $this->commission,
            'blog' => $this->blog,
            'status' => $this->status,
            'end_date' => $this->end_date,
            'blog_commission' => $this->blog_commission,
            'date' => $this->created_at,
            'amount' => $this->amount,
            'duration' => $this->duration,
            'activePlan' => $this->When(
                $this->activePlan,
                function () {
                    return new TutorActivePlanResource($this->activePlan);
                }
            )
        ];
    }
}
