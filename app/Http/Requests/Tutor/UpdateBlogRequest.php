<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add blog validations
 */
class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'media' => 'nullable|mimes:jpeg,jpg,png,pdf,mp4,3gp,mov|
                max:'. config('constants.blog_media.maxSize') * 1000,
            'blog_title' => 'required|string|min:2|max:255',
            'blog_description' => 'required|string|min:30|max:1000',
            'total_fees' => 'required|numeric|min:0|max:1000',
            'category_id' => 'required|integer',
            
        ];
    }

    /**
     * Method messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.required' => __(
                'validation.select_required',
                [
                    'attribute' => 'category'
                ]
            ),
            'level_id.required' => __(
                'validation.select_required',
                [
                    'attribute' => 'level'
                ]
            ),
            'media.max' => __(
                'validation.max_file', 
                [
                    'max' => config('constants.blog_media.maxSize'),
                    'unit' => 'MB'
                ]
            ),
        ];
    }
}
