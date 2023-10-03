<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class QuoteRequest extends ApiRequest
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
            'price' => 'required|numeric',
            'class_request_id' => 'required',
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
            'price.required' => __('validation.required'),
            'class_request_id.required' => __('validation.required'),
        ];
    }
}
