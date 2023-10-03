<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;
use App\Models\User;

class CompleteProfileRequest extends ApiRequest
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
                'introduction_video' => 'sometimes|mimes:mp4,3gp,mov|max:5000',
                'ar.name' => 'nullable|string|min:2|max:50',
                'experience' => 'required|numeric',
                'en.bio' => 'max:5000',
                'ar.bio' => 'nullable|string|min:2|max:5000',
                'address' => 'required|string|min:2|max:255',
                'id_card' => 'sometimes|mimes:jpeg,jpg,png|max:5000'
            ];
        } else {
            return [
                'profile_image' => 'sometimes|image|max:5000',
                'en.bio ' => 'sometimes|string|min:2|max:5000',
                'ar.bio ' => 'nullable|string|min:2|max:5000'
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
            'en.bio.required' => __('validation.required', ['attribute' => 'bio']),
            'en.bio.min' => __('validation.min', ['attribute' => 'bio', 'min' => 2]),
            'en.bio.max' => __('validation.max', ['attribute' => 'bio', 'max' => 5000]),
            'ar.name.min' => __('validation.min', ['attribute' => 'bio', 'min' => 2]),
            'ar.name.max' => __('validation.max', ['attribute' => 'bio', 'max' => 50]),
            'ar.bio.min' => __('validation.min', ['attribute' => 'bio', 'min' => 2]),
            'ar.bio.max' => __('validation.max', ['attribute' => 'bio', 'max' => 5000]),
        ];
    }
}
