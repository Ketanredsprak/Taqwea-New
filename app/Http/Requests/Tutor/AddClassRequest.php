<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add class validations
 */
class AddClassRequest extends FormRequest
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
        $rules = [
            'en.class_name' => 'required|string|min:6|max:191',
            'en.class_description' => 'required|string',
            'ar.class_name' => 'required|string|min:6|max:191',
            'ar.class_description' => 'required|string',
            'category_id' => 'required|integer',
            'level_id' => 'required|integer',
            'grade_id' => 'nullable|integer',
            'subject_id' => 'nullable|integer',
            'class_type' => 'required|in:class,webinar',
        ];
        $rules['class_image'] = 'required_if:class_id,0|mimes:jpeg,jpg,png|max:5000';
        return $rules;
    }

    /**
     * Method messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'en.class_name.required' => __('validation.required'),
            'en.class_name.min' => __('validation.min', ['min' => 6]),
            'en.class_name.max' => __('validation.max', ['max' => 32]),
            'category_id.required' => __('validation.select_required'),
            'level_id.required' => __('validation.select_required'),
            'en.class_description.required' => __('validation.required'),
            'class_image.required_if' => __('validation.select_required'),
            'ar.class_name.required' => __('validation.required'),
            'ar.class_description.required' => __('validation.required')
        ];
    }
}
