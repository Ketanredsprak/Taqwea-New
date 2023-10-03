<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

/**
 * VerificationRequest
 */
class VerificationRequest extends ApiRequest
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
    public function rules():array
    {
        return [
            'otp' => 'required'
        ];
    }
    
    /**
     * Method messages
     *
     * @return array
     */
    public function messages():array
    {
        return [
            'email.check_email_format' => trans('validation.check_email_format'),
        ];
    }

}
