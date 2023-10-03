<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
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
            'en.question' => 'required|string|min:2',
            'en.content' => 'required|string|min:20',
            'ar.question' => 'required|string|min:2',
            'ar.content' => 'required|string|min:20',
            'faq_file' =>  'sometimes|mimes:png,jpg,jpeg,mp4,3gp'
        ];
    }

    /**
     * Method Message
     * 
     * @return array
     */
    public function messages()
    {
        return [
            'en.question.required' => __('validation.required', ['attribute' => 'Question(en)']),
            'ar.question.required' => __('validation.required', ['attribute' => 'Question(ar)']),
            'en.question.min' => __('validation.min', ['attribute' => 'Question(en)', 'min' => 2]),
            'ar.question.min' => __('validation.min', ['attribute' => 'Question(ar)', 'min' => 2]),
            'en.question.max' => __('validation.max', ['attribute' => 'Question(en)', 'max' => 32]),
            'ar.question.max' => __('validation.max', ['attribute' => 'Question(ar)', 'max' => 32]),
            'en.content.required' => __('validation.required', ['attribute' => 'Content(en)']),
            'ar.content.required' => __('validation.required', ['attribute' => 'Content(ar)']),
            'en.content.min' => __('validation.min', ['attribute' => 'Content(en)', 'min' => 20]),
            'ar.content.min' => __('validation.min', ['attribute' => 'Content(ar)', 'min' => 20]),
            'faq_file.required_without' => 'The image field is required',
        ];
    }
}
