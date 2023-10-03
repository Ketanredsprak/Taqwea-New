<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * RevenueResources
 */
class RevenueResources extends JsonResource
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
        $total_amount = (
            (($this->class_sum) + ($this->webinar_sum) + ($this->blog_sum) + ($this->subscription_sum) + ($this->fine_sum))
            - ($this->point_sum/10)
        );
        
        return [
            'class' => number_format($this->class_sum, 2, '.', ''),
            'webinar' => number_format($this->webinar_sum, 2, '.', ''),
            'blog' => number_format($this->blog_sum, 2, '.', ''),
            'subscription' => number_format($this->subscription_sum, 2, '.', ''),
            'date' => Carbon::parse($this->created_at)->format('F'),
            "total" => number_format($total_amount, 2, '.', ''),
            'id' => Carbon::parse($this->created_at)->format('m'),
            'points' => $this->point_sum,
            'pointsInSAR' => $this->point_sum/10,
            'refund' => number_format($this->refund_sum, 2, '.', ''),
            'fine' => number_format($this->fine_sum, 2, '.', ''),
            // $item->points = RewardPoint::getMonthPoints($item->created_at);
        ];
    }
}
