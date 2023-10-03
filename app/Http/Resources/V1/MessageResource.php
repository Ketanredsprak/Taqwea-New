<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class MessageResource extends JsonResource
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
        return [
            "id" => $this->id,
            "uuid" => $this->uuid,
            "student_id" => $this->student_id,
            "tutor_id" => $this->tutor_id,
            'chat_remaining_time' => remainingChatDays($this->created_at),
            "messages" => $this->When(
                $this->messages,
                function () {
                    $messages = [];
                    foreach ($this->messages as $message) {
                        $messages[] = [                   
                            'id' => $message->id,
                            'uuid' => $message->thread_uuid,
                            'thread_id ' => $message->thread_id,
                            'from_id' => $message->from_id,
                            'to_id' => $message->to_id,
                            'message' => $message->message,
                            'created_at' => $message->created_at,
                            'is_readed' => $message->is_readed,
                        ];
                    }
                    return $messages;
                }
            ),
        ];
    }
}
