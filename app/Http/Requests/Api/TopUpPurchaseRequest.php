<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TopUpPurchaseRequest extends FormRequest
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
            'class_hours' => 'required_without_all:blog_count,webinar_hours,is_featured|
            numeric|min:1|regex:'.config('constants.two_decimal_regex'),

            'webinar_hours' => 'sometimes|numeric|min:1|regex:'.
                config('constants.two_decimal_regex'),

            'blog_count' => 'sometimes|integer|min:1',
            'is_featured' => 'sometimes|integer|min:1',


        ];
    }
}
