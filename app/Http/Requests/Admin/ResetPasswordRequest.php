<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'otp' => 'required|digits:4',
            'new_password' => 'required|min:8|max:32|regex:'. config('constants.password_regex'),
            'confirm_password' => 'required|same:new_password',
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
            'new_password.regex' => 'Please enter a password of at least 8 characters with 1 special character, 1 number, and 1-Upper case, make sure numeric characters are not in sequence.',
        ];
    }
}
