<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class AddBlogRequest extends ApiRequest
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
            'media' => 'required|mimes:jpeg,jpg,png,pdf,mp4,3gp,mov|
                max:' . config('constants.blog_media.maxSize') * 1000,
            'en.blog_title' => 'required|string|min:6|max:255',
            'en.blog_description' => 'required|string|min:2|max:5000',
            'ar.blog_title' => 'nullable|string|min:6|max:255',
            'ar.blog_description' => 'nullable|string|min:2|max:5000',
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
            'en.blog_title.required' => __('validation.required', ['attribute' => 'blog title']),
            'en.blog_title.min' => __('validation.min', ['attribute' => 'blog title', 'min' => 6]),
            'en.blog_title.max' => __('validation.max', ['attribute' => 'blog title', 'max' => 225]),
            'ar.blog_title.min' => __('validation.min', ['attribute' => 'blog title', 'min' => 6]),
            'ar.blog_title.max' => __('validation.max', ['attribute' => 'blog title', 'max' => 255]),
            'en.blog_description.required' => __('validation.required', ['attribute' => 'blog description']),
            'en.blog_description.min' => __('validation.min', ['attribute' => 'blog description', 'min' => 6]),
            'en.blog_description.max' => __('validation.max', ['attribute' => 'blog description', 'max' => 5000]),
            'ar.blog_description.min' => __('validation.min', ['attribute' => 'blog description', 'min' => 6]),
            'ar.blog_description.max' => __('validation.max', ['attribute' => 'blog description', 'max' => 5000]),
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
