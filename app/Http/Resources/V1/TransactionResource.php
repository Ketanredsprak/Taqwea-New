<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            "id" => $this->id,
            "transaction_id" => $this->external_id,
            'transaction_type' => $this->transaction_type,
            'transaction_date' => $this->created_at,
            'amount_t' => $this->amount,
            'amount' => $this->total_amount,
            'vat_amount' => $this->vat,
            'transaction_fees' => $this->transaction_fees,
            'payment_mode' => $this->payment_mode,
            'status' => $this->status,
            // 'admin_commission' => $this->admin_commision,
            'items' => $this->When(
                $this->transactionItems,
                function () {
                    return TransactionItemResource::collection($this->transactionItems);
                }
            ),
            'admin_commission' => $this->When(
                $this->transactionItems,
                function () {
                    return [
                        'commission' => formatAmount($this->transactionItems->sum('commission'))
                    ];
                }
            ),
            "blog" => $this->when(
                $this->blog,
                function () {
                    return [
                        'tutor' => $this->blog->tutor()->withTrashed()->getResults()->translateOrDefault()->name,
                    ];
                }
            ),
            "class" => $this->when(
                $this->classWebinar,
                function () {
                    return [
                        'tutor' => $this->classWebinar->tutor()->withTrashed()->getResults()->translateOrDefault()->name,
                    ];
                }
            ),
            "user" => $this->when(
                $this->user()->withTrashed()->getResults(),
                function () {
                    return [
                        'name' => $this->user()->withTrashed()->getResults()->translateOrDefault()->name,
                    ];
                }
            )
        ];
    }
}
