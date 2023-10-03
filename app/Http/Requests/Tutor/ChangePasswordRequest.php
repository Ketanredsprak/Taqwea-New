<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add education validations
 */
class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|validate_current_password',
            'new_password' => 'required|min:8|max:32|validate_new_password|regex:' . config('constants.password_regex'),
            'confirm_password' => 'required|string|same:new_password',
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
            'new_password.regex' => trans('validation.password_regex'),
            'new_password.validate_new_password' => trans('validation.validate_new_password'),
        ];
    }
}
