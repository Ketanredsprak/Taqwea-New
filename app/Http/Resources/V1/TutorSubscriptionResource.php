<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * TutorSubscriptionResource
 */
class TutorSubscriptionResource extends JsonResource
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
        $loggedInUser = Auth::user();
        return [
            'id' => $this->id,
            'allow_booking' => $this->allow_booking,
            'class_hours' => $this->class_hours,
            'webinar_hours' => $this->webinar_hours,
            'featured' => $this->featured,
            'commission' => $this->commission,
            'blog' => $this->blog,
            'status' => $this->status,
            'end_date' => $this->end_date,
            'date' => $this->created_at,
            'expiry_days' => expiryDays($this->end_date),
            "subscription" => $this->when(
                $this->subscription,
                function () {
                    return [
                        'subscription_name' =>
                        $this->subscription->subscription_name,
                        'subscription_description'
                        => $this->subscription->subscription_description,
                    ];
                }
            ),
            'tutor' => $this->when(
                $this->tutor && $loggedInUser && $loggedInUser->isAdmin(),
                [
                    'name' => $this->tutor->name,
                    'email' => $this->tutor->email,
                ]
            ),
            'transaction' => $this->when(
                $loggedInUser && $loggedInUser->isAdmin(),
                [
                    'amount' => @$this->transaction->amount,
                ]
            ),
        ];
    }
}
