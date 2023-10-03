<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add education validations
 */
class AddEducationRequest extends FormRequest
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
            'education_certificate' => 'nullable|mimes:jpeg,jpg,png,pdf|
                max:'. config('constants.education_document.maxSize') * 1000,
            'en.degree' => 'required|string|min:3|max:64',
            'en.university' => 'required|string|min:3|max:64',
            'ar.degree' => 'required|string|min:3|max:64',
            'ar.university' => 'required|string|min:3|max:64',
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
            'education_certificate.max' => __(
                'validation.max_file',
                [
                    'max' => config('constants.education_document.maxSize'),
                    'unit' => 'MB'
                ]
            ),
            'en.degree.required' => __('validation.required'),
            'en.degree.min' => __('validation.min', [ 'min' => 3]),
            'en.degree.max' => __('validation.max', [ 'max' => 64]),
            'en.university.required' => __('validation.required'),
            'en.university.min' => __('validation.min', [ 'min' => 3]),
            'en.university.max' => __('validation.max', [ 'max' => 64]),
            'ar.degree.required'=> __('validation.required'),
            'ar.university.required' => __('validation.required'),
        ];
    }
}
