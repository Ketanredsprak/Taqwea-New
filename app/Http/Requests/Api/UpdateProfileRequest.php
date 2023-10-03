<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;
use App\Models\User;

class UpdateProfileRequest extends ApiRequest
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
        if (auth()->user()->user_type == User::TYPE_TUTOR) {
            return [
                'profile_image' => 'sometimes|image|max:5000',
                'en.name' => 'required|string|min:2|max:50',
                'ar.name' => 'nullable|string|min:2|max:50',
                'email' => 'required|check_email_format
                            |unique:App\Models\User,email,'.$this->user->id.',id,deleted_at,NULL',
                'phone_number' => 'sometimes|digits_between:8,12',
                'address' => 'required|string|min:2|max:255',
                'introduction_video' => 'sometimes|required
                                        |mimes:mp4,3gp,mov|max:5000',
                'experience' => 'required|numeric',
                'en.bio' => 'required|string|min:2|max:5000',
                'ar.bio' => 'nullable|string|min:2|max:5000',
                'id_card' => 'sometimes|required|mimes:jpeg,jpg,png|max:5000'
            ];
        } else {
            return [
                'profile_image' => 'sometimes|image|max:5000',
                'en.name' => 'required|string|min:2|max:50',
                'ar.name' => 'nullable|string|min:2|max:50',
                'email' => 'required|check_email_format
                            |unique:App\Models\User,email,'.$this->user->id.',id,deleted_at,NULL',
                'phone_number' => 'sometimes|digits_between:8,12',
                'en.bio' => 'nullable|string|max:5000',
                'ar.bio' => 'nullable|string|max:5000'
            ];
        }
    }

    /**
     * Method messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'profile_image.max' => __('validation.max_file', ['max' => 5, 'unit' => 'MB']),
            'en.name.required' => __('validation.required', ['attribute' => 'bio']),
            'en.name.min' => __('validation.min', ['attribute' => 'bio', 'min' => 2]),
            'en.name.max' => __('validation.max', ['attribute' => 'bio', 'max' => 50]),
            'ar.name.min' => __('validation.min', ['attribute' => 'bio', 'min' => 2]),
            'ar.name.max' => __('validation.max', ['attribute' => 'bio', 'max' => 50]),

            'en.bio.required' => __('validation.required', ['attribute' => 'bio']),
            'en.bio.min' => __('validation.min', ['attribute' => 'bio', 'min' => 2]),
            'en.bio.max' => __('validation.max', ['attribute' => 'bio', 'max' => 5000]),
            'ar.bio.min' => __('validation.min', ['attribute' => 'bio', 'min' => 2]),
            'ar.bio.max' => __('validation.max', ['attribute' => 'bio', 'max' => 5000]),
        ];
    }
}
