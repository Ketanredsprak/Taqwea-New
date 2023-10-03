<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'user_role' => 'required',
            'profile_image' => 'nullable|image|max:'. config('constants.profile_image.maxSize') * 1000,
            'name' => 'required|string|min:3|max:32',
            'email' => 'required|check_email_format|check_email_exist',
            'phone_number' => 'required|digits_between:8,12',
            'referral_code' => 'nullable|exists:users,referral_code',
            'password' => 'required|string|min:8|max:15|regex:' . config('constants.password_regex'),
            'confirm_password' => 'required|string|same:password',
            'terms_of_service' => 'accepted',
            'gender' => 'required',
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
            'password.regex' => __('validation.password_regex'),
            'email.check_email_exist' => __('validation.check_email_exist'),
            'email.check_email_format' => __('validation.check_email_format'),
            'phone_number.digits_between' => __('validation.digits_between'),
            'terms_of_service.accepted' => __('validation.terms_of_service_accepted'),
            'referral_code.exists' => __('validation.referral_code_not_exists')
        ];
    }
}
