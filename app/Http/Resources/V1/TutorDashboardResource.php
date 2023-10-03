<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Wallet;
class TutorDashboardResource extends JsonResource
{
    /**
     * Method __construct
     *
     * @param $resource $resource 
     * @param $counts   $categories 
     * @param $classes  $classes 
     * @param $webinars $webinars 
     * 
     * @return void
     */
    public function __construct(
        $resource,
        $counts,
        $classes,
        $webinars
    ) {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        $this->counts = $counts;
        $this->classes = $classes;
        $this->webinars = $webinars;
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request 
     * 
     * @return array
     */
    public function toArray($request)
    {
        return [
            'counts' => [
                'classes' => $this->counts['class_count'] ?? 0,
                'webinars' => $this->counts['webinar_count'] ?? 0,
                'earnings' => $this->counts['earnings'],
                'students' => $this->counts['students'] ?? 0,
                'blogs' => $this->counts['blogs'] ?? 0,
                'dues' => $this->counts['dues'] ?? 0,
            ],
            'classes' => ClassResource::collection($this->classes),
            'webinars' => ClassResource::collection($this->webinars),
            'notification_count' => Notification::notificationCounts(Auth::user()),
            'walletBalance' => $this->when(
                (Auth::check()),
                function () {
                    return Wallet::availableBalance(Auth::user()->id);
                }
            ),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request 
     * 
     * @return array
     */
    public function with($request)
    {
        return [
            'meta' => [
                'class_max_students' => config('services.class_max_student'),
                'class_booking_before' => config('services.class_booking_before'),
            ],
        ];
    }
}
