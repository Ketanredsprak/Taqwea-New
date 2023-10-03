<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class SocialLoginRequest extends ApiRequest
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
            'email' => 'required|check_email_format',
            'token' => 'required|string',
            'device_type' => 'required|string|in:ios,android',
            'certification_type' => 'nullable|required_if:device_type,ios'
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
            'email.check_email_exist' => __('validation.check_email_exist'),
            'email.check_email_format' => __('validation.check_email_format'),
        ];
    }
}
