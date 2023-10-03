<?php

namespace App\Http\Requests\Admin;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
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
        return RuleFactory::make(
            [
                'category_id' => 'required',
                'subject_id' => 'required',
            ]
        );
    }

    /**
     * Method messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'category_id.required' => __('validation.category'),
            'subject_id.required' => __('validation.subject'),
        ];
    }
}
