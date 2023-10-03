<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
        $price = 0;
        if (isset($this->blog) && !empty($this->blog)) {
            $price = $this->blog->total_fees;
        }

        if (isset($this->classWebinar) && !empty($this->classWebinar)) {
            $price = (!empty($this->classWebinar->total_fees))
            ?$this->classWebinar->total_fees:$this->classWebinar->hourly_fees;
        }

        return [
            "id" => $this->id,
            "quantity" => $this->qty,
            "price" => $price,
            "unit_price" => $price,
            "blog" => $this->when(
                $this->blog, 
                function () {
                    return [
                        'blog_title' => 
                        $this->blog->translateOrDefault()->blog_title,
                        'media_url' => $this->blog->media_thumb_url,
                        'media_thumb_url' => $this->blog->media_thumb_url,
                        'subject' => $this->blog->subject ? $this->blog->subject->translateOrDefault()->subject_name : ''
                    ];
                }
            ),
            "class" => $this->when(
                $this->classWebinar, 
                function () {
                    return [
                        'class_name' => 
                        $this->classWebinar->translateOrDefault()->class_name,
                        'class_type' => $this->classWebinar->class_type,
                        'duration' => $this->classWebinar->duration,
                        'hourly_fees'=> $this->classWebinar->hourly_fees,
                        'total_fees'=> $this->classWebinar->total_fees,
                        'class_image_url' => $this->classWebinar->class_image_url,
                        'start_time' => $this->classWebinar->start_time,
                        'subject' => $this->classWebinar->subject ? $this->classWebinar->subject->subject_name : '',
                        "status" => $this->classWebinar->status,
                    ];
                }
            ),
        ];
    }
}
