<?php

namespace App\Http\Resources\V1;

use App\Models\RatingReview;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\TransactionItem;
use App\Models\CartItem;

class BlogResource extends JsonResource
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

        if (isset($this->blog_purchased_count)) {
            $is_purchased = ($this->blog_purchased_count) ? true : false;
        } else {
            $is_purchased = TransactionItem::isPurchased($user->id, '', $this->id);
        }

        if (isset($this->cart_item_count)) {
            $is_cart =  ($this->cart_item_count) ? true : false;
        } else {
            $is_cart = CartItem::isCart($user->id, '', $this->id);
        }

        return [
            'id' => $this->id,
            'blog_title' => $this->blog_title,
            'slug' => $this->slug,
            'blog_description' => $this->blog_description,
            'type' => $this->type,
            'media_url' => $this->media_url,
            'media_thumb_url' => $this->media_thumb_url,
            'total_fees' => $this->total_fees,
            'status' => $this->status,
            'is_purchased' => $is_purchased,
            'is_cart' => $is_cart,
            'created_at' => $this->when(
                $user->isAdmin(),
                $this->created_at
            ),
            'tutor' => $this->when(
                $this->tutor,
                function () {
                    return [
                        'id' => $this->tutor->id,
                        'name' => $this->tutor->translateOrDefault()->name,
                        'email' => $this->tutor->email,
                        'bio' => $this->tutor->translateOrDefault()->bio,
                        'profile_image_url' => $this->tutor->profile_image_url,
                        'rating' => RatingReview::getAverageRating($this->tutor->id),
                    ];
                }
            ),
            'category' => $this->when(
                $this->category,
                function () {
                    return [
                        'category_name' => $this->category->translateOrDefault()->name,
                        'category_id' => $this->category->id,
                    ];
                }
            ),
            'grade' => $this->when(
                $this->grade,
                function () {
                    return [
                        'id' => $this->grade->id,
                        'name' => $this->grade->translateOrDefault()->grade_name
                    ];
                }
            ),
            'level' => $this->when(
                $this->level,
                function () {
                    return [
                        'level_name' => $this->level->translateOrDefault()->name,
                        'level_id' => $this->level->id,
                    ];
                }
            ),
            'subject' => $this->when(
                $this->subject,
                function () {
                    return [
                        'id' => $this->subject->id,
                        'subjects' => $this->subject->translateOrDefault()->subject_name,
                    ];
                }
            ),
            'translations' => $this->translations,
        ];
    }
}
