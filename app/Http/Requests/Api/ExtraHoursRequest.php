<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ExtraHoursRequest extends FormRequest
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
            'duration' => 'required|numeric|max:4',
            'extra_hour_charge' => 'required|min:0|regex:'.config('constants.two_decimal_regex').'|numeric'
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
            'extra_hour_charge.regex' => __('validation.two_decimal_regex'),
          
        ];
    }
}
