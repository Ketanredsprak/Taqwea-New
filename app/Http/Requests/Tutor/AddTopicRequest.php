<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add education validations
 */
class AddTopicRequest extends FormRequest
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
            'en.topic_title' => 'required|string|min:2|max:100',
            'en.topic_description' => 'required|string|min:2|max:1000',
            'sub_topics.*' => 'required|string',
            'ar.topic_title' => 'required|string|min:2|max:100',
            'ar.topic_description' => 'required|string|min:2|max:1000',
            // 'sub_topics_ar.*' => 'required|string',
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
            'en.topic_title.required' => __('validation.required'),
            'en.topic_title.min' => __('validation.min', ['attribute' => 'title', 'min' => 2]),
            'en.topic_title.max' => __('validation.max', ['attribute' => 'title', 'max' => 100]),

            'en.topic_description.required' => __('validation.required'),
            'en.topic_description.min' => __('validation.min', ['min' => 2]),
            'en.topic_description.max' => __('validation.max', ['max' => 1000]),

            'sub_topics.*.required' => __('validation.required'),
            'ar.topic_title.required' => __('validation.required'),
            'ar.topic_title.min' => __('validation.min', ['attribute' => 'title', 'min' => 2]),
            'ar.topic_title.max' => __('validation.max', ['attribute' => 'title', 'max' => 100]),

            'ar.topic_description.required' => __('validation.required'),
            'ar.topic_description.min' => __('validation.min', ['min' => 2]),
            'ar.topic_description.max' => __('validation.max', ['max' => 1000]),

            'sub_topics_ar.*.required' => __('validation.required'),
        ];
    }
}
