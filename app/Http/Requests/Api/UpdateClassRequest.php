<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;
use App\Models\ClassWebinar;

class UpdateClassRequest extends ApiRequest
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
            'class_image' => 'sometimes|mimes:jpeg,jpg,png|max:5000',
            'en.class_name' => 'required|string|min:2|max:100',
            'ar.class_name' => 'nullable|string|min:2|max:100',
            'category_id' => 'required|integer',
            'level_id' => 'required|integer',
            'grade_id' => 'sometimes|integer',
            'subject_id' => 'sometimes|integer',
            'class_type' => 'required|in:class,webinar',
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
            'en.class_name.required' => __('validation.required', ['attribute' => 'class name']),
            'en.class_name.min' => __('validation.min', ['attribute' => 'class name', 'min' => 2]),
            'en.class_name.max' => __('validation.max', ['attribute' => 'class name', 'max' => 100]),
            'ar.class_name.min' => __('validation.min', ['attribute' => 'class name', 'min' => 2]),
            'ar.class_name.max' => __('validation.max', ['attribute' => 'class name', 'max' => 100]),
        ];
    }
}
