<?php

namespace App\Http\Resources\V1;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\TutorPayout;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * EarningHistoryResource
 */
class EarningHistoryResource extends JsonResource
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
        $tutorId = $this->blog ? $this->blog->tutor_id : $this->classWebinar->tutor_id;
        $totalTutorPayout = TutorPayout::totalPayout($tutorId);
        $fine = Transaction::totalFine($tutorId);
        return [
            'id' => $this->id,
            'from' => (
                $this->blog ?
                 'Blog': ucfirst($this->classWebinar->class_type)),
            'title' => 
            ($this->blog ? ucwords($this->blog->blog_title)
             : ucwords($this->classWebinar->class_name)),
            'booking_count'=> $this->booking_count,
            'booking_amount' => $this->booking_amount,
            'total_refund' => number_format($this->total_refund, 2),
            'admin_commission' => number_format($this->admin_commission, 2),
            'final_earning' => number_format($this->booking_amount -  $this->admin_commission, 2) ,
            'total_earning' => TransactionItem::totalEarningHistory($tutorId),
            'tutor_payout' =>  $totalTutorPayout,
            'fine' => $this->fine_amount??0,
            'tutor_fine' => $fine,
        ];
    }
}
