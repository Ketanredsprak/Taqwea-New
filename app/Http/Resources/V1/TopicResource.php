<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TopicResource extends JsonResource
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
            'id' => $this->id,
            'topic_title' => $this->translateOrDefault()->topic_title,
            'topic_description' => $this->translateOrDefault()->topic_description,
            'sub_topics' => $this->mergeWhen(
                $this->subTopics,
                function () {
                    return SubTopicResource::collection($this->subTopics);
                }
            ),
            'translations' => $this->translations
        ];
    }
}
