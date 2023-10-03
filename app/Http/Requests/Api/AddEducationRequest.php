<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class AddEducationRequest extends ApiRequest
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
            'certificate' => 'nullable|mimes:jpeg,jpg,png,pdf|
                max:'. config('constants.education_document.maxSize') * 1000,
            'en.degree' => 'required|string|min:2|max:100',
            'en.university' => 'required|string|min:2|max:100',
            'ar.degree' => 'nullable|string|min:2|max:100',
            'ar.university' => 'nullable|string|min:2|max:100',
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
            'en.degree.required' => __('validation.required', ['attribute' => 'degree name']),
            'en.degree.min' => __('validation.min', ['attribute' => 'degree name', 'min' => 2]),
            'en.degree.max' => __('validation.max', ['attribute' => 'degree name', 'max' => 100]),
            'en.university.required' => __('validation.required', ['attribute' => 'university name']),
            'en.university.min' => __('validation.min', ['attribute' => 'university name', 'min' => 2]),
            'en.university.max' => __('validation.max', ['attribute' => 'university name', 'max' => 100]),
            'ar.degree.required' => __('validation.required', ['attribute' => 'degree name']),
            'ar.degree.min' => __('validation.min', ['attribute' => 'degree name', 'min' => 2]),
            'ar.degree.max' => __('validation.max', ['attribute' => 'degree name', 'max' => 100]),
            'ar.university.required' => __('validation.required', ['attribute' => 'university name']),
            'ar.university.min' => __('validation.min', ['attribute' => 'university name', 'min' => 2]),
            'ar.university.max' => __('validation.max', ['attribute' => 'university name', 'max' => 100]),
            'certificate.max' => __(
                'validation.max_file',
                [
                    'max' => config('constants.education_document.maxSize'),
                    'unit' => 'MB'
                ]
            ),
        ];
    }
}
