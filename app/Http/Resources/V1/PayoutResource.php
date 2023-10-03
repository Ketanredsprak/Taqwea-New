<?php

namespace App\Http\Resources\V1;

use App\Models\Transaction;
use App\Models\TutorPayout;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * PayoutResource 
 */
class PayoutResource extends JsonResource
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
        $totalFine = Transaction::totalFine($this->tutor_id, 1);
        $totalPayout = TutorPayout::totalPayout($this->tutor_id);
        $total = $totalPayout + $totalFine;
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'status' => ucfirst($this->status),
            'account_number' => $this->account_number,
            'total_amount' => $total,
        ];
    }
}
