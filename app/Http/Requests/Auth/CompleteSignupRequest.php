<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CompleteSignupRequest extends FormRequest
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

        $rules['user_role'] = 'required';
        $rules['terms_of_service'] = 'accepted';
        $rules['name'] = 'required|string|min:3|max:32';
        $rules['email'] = 'required|check_email_format
            |unique:App\Models\User,email,'.$this->id.',id';
        $rules['gender'] = 'required';

        return $rules;
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
            'terms_of_service.accepted' => __('validation.terms_of_service_accepted'),
        ];
    }
}
