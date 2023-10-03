<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request  $request 
     * @return array 
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->subscription->translateOrDefault()->subscription_name,
            'transaction' => $this->When(
                $this->transaction,
                function () {
                    return new TransactionResource($this->transaction);
                }
            )
        ];
    }
}
