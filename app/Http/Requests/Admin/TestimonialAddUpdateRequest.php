<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialAddUpdateRequest extends FormRequest
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
            'en.name' => 'required|string|min:2|max:32',
            'en.content' => 'required|string|min:20',
            'ar.name' => 'required|string|min:2|max:32',
            'ar.content' => 'required|string|min:20',
            'rating' => 'required|integer|min:1|max:5',
            'testimonial_file' => 'required_without:old_images|mimes:jpeg,jpg,png|max:5000,',
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
            'en.name.required' => __('validation.required', ['attribute' => 'Name(en)']),
            'ar.name.required' => __('validation.required', ['attribute' => 'Name(ar)']),
            'en.name.min' => __('validation.min', ['attribute' => 'Name(en)', 'min' => 2]),
            'ar.name.min' => __('validation.min', ['attribute' => 'Name(ar)', 'min' => 2]),
            'en.name.max' => __('validation.max', ['attribute' => 'Name(en)', 'max' => 32]),
            'ar.name.max' => __('validation.max', ['attribute' => 'Name(ar)', 'max' => 32]),
            'en.content.required' => __('validation.required', ['attribute' => 'Content(en)']),
            'ar.content.required' => __('validation.required', ['attribute' => 'Content(ar)']),
            'en.content.min' => __('validation.min', ['attribute' => 'Content(en)', 'min' => 20]),
            'ar.content.min' => __('validation.min', ['attribute' => 'Content(ar)', 'min' => 20]),
            'testimonial_file.required_without' =>'The images field is required.',
        ];
    }
}
