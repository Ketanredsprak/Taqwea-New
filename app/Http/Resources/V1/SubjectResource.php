<?php

namespace App\Http\Resources\V1;

use App\Models\Subject;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /**
         * User
         * 
         * @var $loggedInUser User 
         **/
        $loggedInUser = Auth::user();
       return  [
            'id' => $this->id ?? $this->subject_id,
            'subjects' => $this->subject_name,
            'subject_icon' => $this->id ? $this->subject_icon_url : $this->subject->subject_icon_url,
            "class_count" => $this->class_count !== null ? $this->class_count : 0,
            "webinar_count" => $this->webinar_count !== null ?
            $this->webinar_count : 0,
            "tutor_count" => $this->tutor_count !== null ?
            $this->tutor_count : 0,
            'translations' => $this->when(
                $loggedInUser && $loggedInUser->isAdmin(),
                function () {
                    $subject = Subject::where('id', $this->id)->first();
                    $translations = [];
                    if ($subject->translations) {
                        foreach ($subject->translations as $translation) {
                            $translations[$translation->language] = $translation->subject_name;
                        } 
                    }
                    return $translations;
                }
            ),
        ];
    }
}
