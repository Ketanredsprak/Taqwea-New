<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditSettingRequest extends FormRequest
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
        $rule = 'required|active_url';
        return [
            'google_link' => $rule,
            'app_store_link' => $rule,
            'facebook_link' => $rule,
            'twitter_link' => $rule,
            'youtube_link' => $rule,
            'instagram_link' => $rule,
            'phone_number' => 'required|max:15',
        ];
    }
}
