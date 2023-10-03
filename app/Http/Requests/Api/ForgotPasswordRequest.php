<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

/**
 * ForgotPasswordRequest
 */
class ForgotPasswordRequest extends ApiRequest
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
            'email' => 'required|exists:users,email'
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
            'email.check_email_format' => trans('validation.check_email_format'),
            'email.user_not_exists' => trans('validation.not_verified'),
        ];
    }
    
}
