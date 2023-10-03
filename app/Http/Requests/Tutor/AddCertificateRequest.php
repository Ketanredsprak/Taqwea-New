<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add certificate validations
*/
class AddCertificateRequest extends FormRequest
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
            'en.certificate_name' => 'required|string|min:3|max:64',
            'ar.certificate_name' => 'required|string|min:3|max:64',
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
            'certificate.max' => __(
                'validation.max_file',
                [
                    'max' => config('constants.certificate_document.maxSize'),
                    'unit' => 'MB'
                ]
            ),
            'en.certificate_name.required' => __('validation.required'),
            'en.certificate_name.min' => __('validation.min', [ 'min' => 3]),
            'en.certificate_name.max' => __('validation.max', [ 'max' => 64]),
        ];
    }
}
