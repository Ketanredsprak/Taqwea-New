<?php

namespace App\Http\Resources\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CategoryResource extends JsonResource
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
         * @var $loggedInUser User 
         **/
        $loggedInUser = Auth::user();
        return [
            'id' => $this->id,
            'name' => $this->translateOrDefault()->name,
            'icon' => $this->icon_url,
            'parent_id' => $this->parent_id,
            'grades_count' => ($this->parent_id)?$this->grades->count():0,
            'translations' => $this->when(
                $loggedInUser && $loggedInUser->isAdmin(),
                function () {
                    $category = Category::where('id', $this->id)->first();
                    $translations = [];
                    if ($category->translations) {
                        foreach ($category->translations as $translation) {
                            $translations[$translation->language] = $translation->name;
                        } 
                    }
                    return $translations;
                }
            ),
            "class_count" => $this->class_count !== null ? $this->class_count : 0,
            "webinar_count" => $this->webinar_count !== null ?
            $this->webinar_count : 0,
            "tutor_count" => $this->tutor_count !== null ?
            $this->tutor_count : 0,
            "subject_count" => $this->subject_count !== null ?
            $this->subject_count : 0,

        ];
    }
}
