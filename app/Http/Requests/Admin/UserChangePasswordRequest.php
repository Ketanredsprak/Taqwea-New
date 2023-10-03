<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserChangePasswordRequest extends FormRequest
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
            'new_password' => 'required|min:8|max:32|validate_new_password:'.$this->id.'|regex:'. config('constants.password_regex'),
            'confirm_password' => 'required|min:8|max:32|same:new_password',
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
            'new_password.regex' =>  trans('validation.password_regex'),
            'new_password.validate_new_password' => trans('validation.validate_new_password'),
        ];
    }
}
