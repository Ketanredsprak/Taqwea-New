<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class RefundRequestResource extends JsonResource
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
            'class_id' => $this->class_id,
            'student_id' => $this->user_id,
            'dispute_reason' => $this->dispute_reason,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'class' => $this->when(
                $this->class,
                function () {
                    return new ClassResource($this->class);
                }
            ),
            'student' => $this->when(
                $this->student,
                function () {
                    return new UserResource($this->student);
                }
            ),
            'transactionItem' => $this->when(
                $this->transactionItem,
                function () {
                    return new TransactionItemResource($this->transactionItem);
                }
            )
        ];
    }
}
