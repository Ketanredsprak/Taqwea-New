<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class SignupRequest extends ApiRequest
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
            'profile_image' => 'sometimes|image|max:5000',
            'en.name' => 'required|string|min:2|max:50',
            'ar.name' => 'nullable|string|min:2|max:50',
            'email' => 'required|check_email_format|check_email_exist',
            'phone_number' => 'required|digits_between:8,12',
            'referral_code' => 'sometimes|exists:users,referral_code',
            'password' => 'required|string|min:8|max:15|regex:'. config('constants.password_regex'),
            'confirm_password' => 'required|string|same:password',
            'terms_of_service' => 'accepted',
            'user_type' => 'required',
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
            'en.name.required' => __('validation.required', ['attribute' => 'name']),
            'en.name.min' => __('validation.min', ['attribute' => ' name', 'min' => 2]),
            'en.name.max' => __('validation.max', ['attribute' => 'name', 'max' => 50]),
            'ar.name.min' => __('validation.min', ['attribute' => ' name', 'min' => 2]),
            'ar.name.max' => __('validation.max', ['attribute' => 'name', 'max' => 50]),
            'password.regex' => __('validation.password_regex'),
            'email.check_email_exist' => __('validation.check_email_exist'),
            'email.check_email_format' => __('validation.check_email_format'),
            'referral_code.exists' => __('validation.referral_code_not_exists'),
            'profile_image.max' => __('validation.max_file', ['max' => 5, 'unit' => 'MB']),
        ];
    }

}
