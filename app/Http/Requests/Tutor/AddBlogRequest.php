<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add blog validations
 */
class AddBlogRequest extends FormRequest
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
            'en.blog_title' => 'required|string|min:6|max:255',
            'media' => 'required|mimes:jpeg,jpg,png,pdf,mp4,3gp,mov|
                max:' . config('constants.blog_media.maxSize') * 1000,
            'en.blog_description' => 'required|string|min:2|max:5000',
            'total_fees' => 'required|numeric|min:10|max:1000',
            'category_id' => 'required|integer',
            'ar.blog_title' => 'required|string|min:6|max:255',
            'ar.blog_description' => 'required|string|min:2|max:5000',
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
            'ar.blog_title.required' => __('validation.required'),
            'ar.blog_description.required' => __('validation.required'),
            'en.blog_description.required' => __('validation.required'),
            'category_id.required' => __(
                'validation.select_required'
            ),
            'level_id.required' => __(
                'validation.select_required',
                [
                    'attribute' => 'level'
                ]
            ),
            'media.required' => __(
                'validation.select_required',
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
