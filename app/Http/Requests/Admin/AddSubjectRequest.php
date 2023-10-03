<?php

namespace App\Http\Requests\Admin;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class AddSubjectRequest extends FormRequest
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
                'en.subject_name' => 'required|string|min:2|max:32|unique:subject_translations,subject_name,'.$this->id.',subject_id',
                'ar.subject_name' => 'required|string|min:2|max:32|unique:subject_translations,subject_name,'.$this->id.',subject_id',
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
            'en.subject_name.required' => __('validation.required', ['attribute' => 'Subject Name(en)']),
            'ar.subject_name.required' => __('validation.required', ['attribute' => 'Subject Name(ar)']),
            'en.subject_name.min' => __('validation.min', ['attribute' => 'Name(en)', 'min' => 2]),
            'ar.subject_name.min' => __('validation.min', ['attribute' => 'Name(ar)', 'min' => 2]),
            'en.subject_name.max' => __('validation.max', ['attribute' => 'Name(en)', 'max' => 32]),
            'ar.subject_name.max' => __('validation.max', ['attribute' => 'Name(ar)', 'max' => 32]),
            'en.subject_name.unique' => __('validation.unique', ['attribute' => 'Subject Name(en)']),
            'ar.subject_name.unique' => __('validation.unique', ['attribute' => 'Subject Name(ar)']),
        ];
    }
}
