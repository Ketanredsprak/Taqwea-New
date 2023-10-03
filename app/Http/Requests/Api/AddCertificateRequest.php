<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class AddCertificateRequest extends ApiRequest
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
                max:'. config('constants.certificate_document.maxSize') * 1000,
            'en.certificate_name' => 'required|string|min:2|max:100',
            'ar.certificate_name' => 'nullable|string|min:2|max:100',
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
            'en.certificate_name.required' => __('validation.required', ['attribute' => 'certificate name']),
            'en.certificate_name.min' => __('validation.min', ['attribute' => 'certificate name', 'min' => 2]),
            'en.certificate_name.max' => __('validation.max', ['attribute' => 'certificate name', 'max' => 100]),
            'ar.certificate_name.required' => __('validation.required', ['attribute' => 'certificate name']),
            'ar.certificate_name.min' => __('validation.min', ['attribute' => 'certificate name', 'min' => 2]),
            'ar.certificate_name.max' => __('validation.max', ['attribute' => 'certificate name', 'max' => 100]),
            'certificate.max' => __(
                'validation.max_file',
                [
                    'max' => config('constants.certificate_document.maxSize'),
                    'unit' => 'MB'
                ]
            ),
        ];
    }
}
