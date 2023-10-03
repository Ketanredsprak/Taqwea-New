<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MessageThreadResource extends JsonResource
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
        $user = Auth::user();
        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "un_read_message" => $this->messages_count,
            "messages" => $this->when(
                $this->messages,
                function () {
                    return $this->messages;
                }
            ),
            "students" =>  $this->When(
                $this->student && $user->user_type == User::TYPE_TUTOR,
                function () {
                    return [                   
                        'id' => $this->student->id,
                        'name' => $this->student->translateOrDefault()->name,
                        'profile_image_url' => $this->student->profile_image_url,
                    ];
                }
            ),
            "tutor" =>  $this->When(
                $this->tutor && $user->user_type == User::TYPE_STUDENT,
                function () {
                    return [                   
                        'id' => $this->tutor->id,
                        'name' => $this->tutor->translateOrDefault()->name,
                        'profile_image_url' => $this->tutor->profile_image_url,
                    ];
                }
            ),
            "classes" =>  $this->When(
                $this->class,
                function () {
                    return [                   
                        'id' => $this->class->id,
                        'class_name' => 
                        $this->class->translateOrDefault()->class_name,
                        'class_image_url' => $this->class->class_image_url,
                    ];
                }
            )
            
        ];
    }
}
