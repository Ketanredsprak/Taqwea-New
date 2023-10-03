<?php

namespace App\Http\Resources\V1;

use App\Models\RewardPoint;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Wallet;
class WalletResource extends JsonResource
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
            'amount' => $this->amount,
            'type' => $this->type,
            'availableBalance' => Wallet::availableBalance($this->user_id),
            'availablePoint' => RewardPoint::getUserPoints($this->user_id),            
            'transaction' => $this->When(
                $this->transaction,
                function () {
                    return new TransactionResource($this->transaction);
                }
            )
        ];
    }
}
