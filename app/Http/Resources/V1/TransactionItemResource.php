<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $refundData = calculationRefundAmount($this);
        return [
            'id' => $this->id,
            "transaction_id" => $this->transaction_id,
            'amount_paid' => $this->amount,
            'total_amount' => $this->total_amount,
            'total_refund_amount' => $refundData['amount'],
            'commission' =>$this->commission,
            'purchase_date' => $this->created_at,
            "blog" => $this->when(
                $this->blog,
                function () {
                    return new BlogResource($this->blog);
                }
            ),
            "class" => $this->when(
                $this->classWebinar,
                function () {
                    return [
                        'tutor' =>
                        $this->classWebinar->tutor()->withTrashed()->getResults()->translateOrDefault()->name,
                        'class_name'
                        => $this->classWebinar->translateOrDefault()->class_name,
                    ];
                }
            ),
            'student' => $this->when(
                $this->student,
                [
                    'id' => $this->student->id,
                    'name' => $this->student->translateOrDefault()->name,
                    'rating' => "2.0",
                    'profile_image_url' => $this->student->profile_image_url,
                    'email' => $this->student->email
                ]
            ),
        ];
    }
}
