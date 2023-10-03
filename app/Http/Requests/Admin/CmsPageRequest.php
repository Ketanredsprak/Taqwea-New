<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CmsPageRequest class
 */
class CmsPageRequest extends FormRequest
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
            'en.page_title' => 'required_if:language,en|string|min:2|max:100|unique:cms_page_translations,page_title,'.$this->id.',cms_page_id',
            'ar.page_title' => 'required_if:language,ar|string|min:2|max:100|unique:cms_page_translations,page_title,'.$this->id.',cms_page_id',
            'en.page_content' => 'required_if:language,en|string|max:16777215',
            'ar.page_content' => 'required_if:language,ar|string|max:16777215',
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
            'en.page_title.required_if' => __('validation.required', ['attribute' => 'Page Title(en)']),
            'ar.page_title.required_if' => __('validation.required', ['attribute' => 'Page Title(ar)']),
            'en.page_title.min' => __('validation.min', ['attribute' => 'Page Title(en)', 'min' => 2]),
            'ar.page_title.min' => __('validation.min', ['attribute' => 'Page Title(ar)', 'min' => 2]),
            'en.page_title.max' => __('validation.max', ['attribute' => 'Page Title(en)', 'max' => 100]),
            'ar.page_title.max' => __('validation.max', ['attribute' => 'Page Title(ar)', 'max' => 100]),
            'en.page_title.unique' => __('validation.unique', ['attribute' => 'Page Title(en)']),
            'ar.page_title.unique' => __('validation.unique', ['attribute' => 'Page Title(ar)']),
            'en.page_content.required_if' => __('validation.required', ['attribute' => 'Page Conetnt(en)']),
            'ar.page_content.required_if' => __('validation.required', ['attribute' => 'Page Conetnt(ar)']),
            'en.page_content.max' => __('validation.max', ['attribute' => 'Page Conetnt(en)', 'max' => 10000]),
            'ar.page_content.max' => __('validation.max', ['attribute' => 'Page Conetnt(ar)', 'max' => 10000]),
        ];
    }
}
