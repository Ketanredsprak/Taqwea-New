<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FilterDataResource extends JsonResource
{
    /**
     * Method __construct
     *
     * @param $resource         $resource [explicite description]
     * @param $categories       $categories [explicite description]
     * @param $subjects         $subjects [explicite description]
     * @param $grades           $grades [explicite description]
     * @param $generalKnowledge $generalKnowledge [explicite description]
     * @param $language         $language [explicite description]
     *
     * @return void
     */

    public function __construct(
        $resource,
        $categories,
        $subjects,
        $grades,
        $generalKnowledge,
        $language
    ) {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        $this->categories = $categories;
        $this->subjects = $subjects;
        $this->grades = $grades;
        $this->generalKnowledge = $generalKnowledge;
        $this->language = $language;
       
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return array
     */
    public function toArray($request)
    {
        return [
            'class_level' => CategoryResource::collection($this->categories),
            'subjects' => SubjectResource::collection($this->subjects),
            'grades' => GradeResource::collection($this->grades),
            'general_knowledge' => CategoryResource::collection($this->generalKnowledge),
            'language' => CategoryResource::collection($this->language),
           
        ];
    }
}
