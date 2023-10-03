<?php

namespace App\Http\Resources\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CategorySubjectResource extends JsonResource
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
            'category_name' => $this->category_name,
            'category_id' => $this->category_id,
            'translations' => $this->when(
                $loggedInUser && $loggedInUser->isAdmin(),
                function () {
                    $category = Category::where('id', $this->category_id)->first();
                    $translations = [];
                    if ($category->translations) {
                        foreach ($category->translations as $translation) {
                            $translations[$translation->language] = $translation->name;
                        } 
                    }
                    return $translations;
                }
            ),
            'grade_name' => $this->grade_name,
            'subjects' => $this->subjects
        ];
    }
}
