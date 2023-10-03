<?php

namespace App\Http\Requests\Admin;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
                'en.name' => 'required|string|min:2|max:32|unique:category_translations,name,'.$this->category.',category_id',
                'ar.name' => 'required|string|min:2|max:32|unique:category_translations,name,'.$this->category.',category_id',
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
            'en.name.required' => __('validation.required', ['attribute' => 'Name(en)']),
            'ar.name.required' => __('validation.required', ['attribute' => 'Name(ar)']),
            'en.name.min' => __('validation.min', ['attribute' => 'Name(en)', 'min' => 2]),
            'ar.name.min' => __('validation.min', ['attribute' => 'Name(ar)', 'min' => 2]),
            'en.name.max' => __('validation.max', ['attribute' => 'Name(en)', 'max' => 32]),
            'ar.name.max' => __('validation.max', ['attribute' => 'Name(ar)', 'max' => 32]),
            'en.name.unique' => __('validation.unique', ['attribute' => 'Name(en)']),
            'ar.name.unique' => __('validation.unique', ['attribute' => 'Name(ar)']),
        ];
    }
}
