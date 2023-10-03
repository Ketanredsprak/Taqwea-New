<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
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
            'en.bank_name' => 'required|string|min:2|max:32',
            'ar.bank_name' => 'required|string|min:2|max:32',
            'bank_code' => 'required|string|min:3|max:40'
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
            'en.bank_name.required' => __('validation.required', ['attribute' => 'Bank Name(en)']),
            'ar.bank_name.required' => __('validation.required', ['attribute' => 'Bank Name(ar)']),
            'en.bank_name.min' => __('validation.min', ['attribute' => 'Bank Name(en)', 'min' => 2]),
            'ar.bank_name.min' => __('validation.min', ['attribute' => 'Bank Name(ar)', 'min' => 2]),
            'en.bank_name.max' => __('validation.max', ['attribute' => 'Bank Name(en)', 'max' => 32]),
            'ar.bank_name.max' => __('validation.max', ['attribute' => 'Bank Name(ar)', 'max' => 32]),
        ];
    }
}
