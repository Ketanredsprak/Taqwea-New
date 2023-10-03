<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add personal details of tutor validations
 */
class PersonalDetailRequest extends FormRequest
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
        $rules = [
            'profile_image' => 'nullable|
                max:'. config('constants.profile_image.maxSize') * 1000,
            'en.name' => 'required|string|min:3|max:32',
            'en.bio' => 'max:5000',
            'email' => 'required|check_email_format|
                unique:App\Models\User,email,' . $this->user->id . ',id,deleted_at,NULL',
            'phone_number' => 'required|digits_between:8,12',
            'address' => 'required|string|min:2|max:255',
            'ar.name' => 'required|string|min:3|max:32',
            'ar.bio' => 'required|string|min:10|max:5000',
        ];
        if (empty(auth()->user()->tutor->id_card)) {
            $rules['id_card'] = 'nullable|mimes:jpeg,jpg,png|
                max:'. config('constants.id_card.maxSize')*1000;
        }
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
            'profile_image.max' => __(
                'validation.max_file',
                [
                    'max' => config('constants.profile_image.maxSize'),
                    'unit' => 'MB'
                ]
            ),
            'id_card.max' => __(
                'validation.max_file',
                [
                    'max' => config('constants.id_card.maxSize'),
                    'unit' => 'MB'
                ]
            ),
        ];
    }
}
