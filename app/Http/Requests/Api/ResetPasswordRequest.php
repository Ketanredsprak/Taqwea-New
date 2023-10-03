<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

/**
 * ResetPasswordRequest
 */
class ResetPasswordRequest extends ApiRequest
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
            'otp' => 'required|numeric',
            'new_password' => 'required|min:8|max:30|regex:'. config('constants.password_regex'),
            'confirm_password' => 'required|string|min:6|max:30|same:new_password',
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
            'current_password.validate_current_password' => trans('validation.current_password_not_match'),
            'email.check_email_format' => trans('validation.check_email_format'),
            'new_password.regex' => trans('validation.password_regex'),
        ];
    }

}
