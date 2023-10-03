<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

/**
 * LoginFormRequest
 */
class LoginFormRequest extends ApiRequest
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
            'email' => 'required_without:phone_number|check_email_format',
            'phone_code' => 'required_with:phone_number',
            'phone_number' => 'required_without:email',
            'password' => 'required',
            'device_type' => 'required|string|in:ios,android',
            'certification_type' => 'nullable|required_if:device_type,ios'
        ];
    }
    
    /**
     * Method messages
     *
     * @return void
     */
    public function messages()
    {
        return [
            'email.required' => __('Email field is required.'),
            'password.required' => __('Password field is required.'),
        ];
    }

}
