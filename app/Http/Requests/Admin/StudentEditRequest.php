<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StudentEditRequest extends FormRequest
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
            'profile_image' => 'nullable|image|max:5000',
            'name' => 'required|string|min:2|max:32',
            'email' => 'required|check_email_format
            |unique:App\Models\User,email,'.$this->student.',id,deleted_at,NULL',
            'phone_number' => 'nullable|digits_between:8,12|
            unique:App\Models\User,phone_number,'.$this->student.',id,deleted_at,NULL',
            'bio' => 'nullable|string|max:2500',
        ];
    }
}
