<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add certificate validations
*/
class AddQuoteRequest extends FormRequest
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
            'note' => 'required',
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
            'note.required' => __('validation.required'),
        ];
    }
}
