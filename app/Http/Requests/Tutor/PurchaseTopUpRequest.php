<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseTopUpRequest extends FormRequest
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
            'class_hours' => 'required_without_all:blog,webinar_hours,is_featured|
            min:1|regex:' . config('constants.two_decimal_regex'),

            'webinar_hours' => 'sometimes|min:1|regex:' .
                config('constants.two_decimal_regex'),

            'blog' => 'sometimes|integer|min:1',
            'is_featured' => 'sometimes|integer|min:1',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'is_featured.sometimes' => trans('validation.is_featured'),
            'is_featured.integer' =>  trans('validation.is_featured'),
            'class_hours.regex' => trans('validation.class_hours'),
            'webinar_hours.regex' => trans('validation.webinar_hours'),
            'class_hours.required_without_all' => trans('validation.class_without_all')
        ];
    }
}
