<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profile_image' =>
                'sometimes|max:'. config('constants.profile_image.maxSize') * 1000,
            'en.name' => 'required|string|min:3|max:32',
            'email' => 'required|check_email_format|
                unique:App\Models\User,email,'.$this->user->id.',id,deleted_at,NULL',
            'phone_number' => 'required|digits_between:8,12',
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
            'en.name.required' => __('validation.required'),
            'en.name.min' => __(
                'validation.min',
                ['min' => 3]
            ),
            'en.name.max' => __(
                'validation.max',
                [ 'max' => 32]
            ),
            'profile_image.max' => __(
                'validation.max_file',
                ['max' => config('constants.profile_image.maxSize'), 'unit' => 'MB']
            ),
            'email.check_email_format' => __('validation.check_email_format'),
        ];
    }
}
