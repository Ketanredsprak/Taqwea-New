<?php

namespace App\Http\Resources\V1;

use App\Models\RatingReview;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionItem;
use App\Models\CartItem;

class ClassResource extends JsonResource
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
        /**
         * User
         * 
         * @var $user User 
         **/
        $user = Auth::user();
        if (isset($this->bookings)) {
            $is_purchased = checkClassBlogBooked($this->id, 'class');
        } else {
            $is_purchased = TransactionItem::isPurchased($user->id, $this->id, '');
        }

        if (isset($this->cart_item_count)) {
            $is_cart =  ($this->cart_item_count) ? true:false;
        } else {
            $is_cart = CartItem::isCart($user->id, $this->id, '');
        }

        return [
            'id' => $this->id,
            'class_name' => $this->translateOrDefault()->class_name,
            'slug' => $this->slug,
            'class_type' => $this->class_type,
            'class_detail' => $this->translateOrDefault()->class_detail,
            'class_description' => $this->translateOrDefault()->class_description,
            'class_image_url' => $this->class_image_url,
            'hourly_fees' => $this->hourly_fees,
            'total_fees' => $this->total_fees,
            'gender_preference' => $this->gender_preference,
            'extra_hour_charge' => $this->extra_hour_charge,
            'extra_duration' => $this->extra_duration,
            'status' => $this->status,
            'is_published' => $this->is_published,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'no_of_attendee' => $this->no_of_attendee,
            'duration' => $this->duration,
            'is_booked' => $is_purchased,
            'is_started' => $this->is_started,
            'is_live' => $this->is_live,
            'is_cart' => $is_cart,
            'uuid' => $this->when(
                $this->chatThread,
                function () {
                    return [
                        'uuid' => $this->chatThread->uuid,
                    ];
                }
            ),
            "booking" => $this->when(
                count($this->bookings),
                function () {
                    return [
                        'id' => $this->bookings[0]->id,
                    ];
                }
            ),
            'tutor' => $this->when(
                $this->tutor()->withTrashed() &&
                $this->tutor_id != Auth::user()->id,
                function () {
                    
                    
                    return [
                        'id' => $this->tutor()->withTrashed()->getResults()->id,
                        'name' => $this->tutor()->withTrashed()->getResults()->translateOrDefault()->name,
                        'email' => $this->tutor()->withTrashed()->getResults()->email,
                        'profile_image_url' => $this->tutor()->withTrashed()->getResults()->profile_image_url,
                        'bio' => $this->tutor()->withTrashed()->getResults()->translateOrDefault()->bio,
                        'rating' => RatingReview::getAverageRating($this->tutor()->withTrashed()->getResults()->id),
                    ];
                }
            ),
            'subject' => $this->when(
                $this->subject,
                function () {
                    return [
                        'id' => $this->subject->id,
                        'name' => $this->subject->translateOrDefault()->subject_name
                    ];
                }
            ),
            'student_count' => $this->bookings_count,
            'category' => new CategoryResource($this->category),
            'level' => new CategoryResource($this->level),
            'grade' => new GradeResource($this->grade),
            'topics' => $this->when(
                $this->topics,
                function () {
                    return TopicResource::collection($this->topics);
                }
            ),
            'translations' => $this->translations,
            "is_rating" => (isset($this->rating_count) && $this->rating_count)
                ?true:false,
            "is_raise_dispute" => (isset($this->raise_dispute_count) 
                && $this->raise_dispute_count)?true:false,
            "bookings" =>$this->when(
                count($this->bookings)
                && $this->tutor_id == Auth::user()->id,
                function () {
                    return ClassBookingResource::collection($this->bookings);
                }
            ),
            
        ];
    }
}
