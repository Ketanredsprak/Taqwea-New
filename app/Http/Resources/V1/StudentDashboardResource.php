<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
class StudentDashboardResource extends JsonResource
{    
    /**
     * Method __construct
     *
     * @param $resource       $resource      [explicite description]
     * @param $categories     $categories    [explicite description]
     * @param $featuredTutors $feturedTutors [explicite description]
     * @param $classes        $classes       [explicite description]
     * @param $webinars       $webinars      [explicite description]
     * @param $blogs          $blogs         [explicite description]
     *
     * @return void
     */
    public function __construct(
        $resource,
        $categories,
        $featuredTutors,
        $classes,
        $webinars,
        $blogs,
        $cart
    ) {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        $this->categories = $categories;
        $this->featuredTutors = $featuredTutors;
        $this->classes = $classes;
        $this->webinars = $webinars;
        $this->blogs = $blogs;
        $this->cart = $cart;
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
            'categories' => CategoryResource::collection($this->categories),
            'featured_tutors' => UserResource::collection($this->featuredTutors),
            'classes' => ClassResource::collection($this->classes),
            'webinars' => ClassResource::collection($this->webinars),
            'blogs' => BlogResource::collection($this->blogs),
            'notification_count' => Notification::notificationCounts(Auth::user()),
            'cart_count' => ($this->cart) ? count($this->cart->items):0,
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
