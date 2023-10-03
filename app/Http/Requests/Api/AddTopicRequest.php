<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class AddTopicRequest extends ApiRequest
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
            'en.topic_title.required' => __('validation.required', ['attribute' => 'topic title']),
            'en.topic_title.min' => __('validation.min', ['attribute' => 'topic title', 'min' => 2]),
            'en.topic_title.max' => __('validation.max', ['attribute' => 'topic title', 'max' => 100]),
            'en.topic_description.required' => __('validation.required', ['attribute' => 'topic description']),
            'en.topic_description.min' => __('validation.min', ['attribute' => 'topic description', 'min' => 2]),
            'en.topic_description.max' => __('validation.max', ['attribute' => 'topic description', 'max' => 1000]),
            'ar.topic_title.required' => __('validation.required', ['attribute' => 'topic title']),
            'ar.topic_title.min' => __('validation.min', ['attribute' => 'topic title', 'min' => 2]),
            'ar.topic_title.max' => __('validation.max', ['attribute' => 'topic title', 'max' => 100]),
            'ar.topic_description.required' => __('validation.required', ['attribute' => 'topic description']),
            'ar.topic_description.min' => __('validation.min', ['attribute' => 'topic description', 'min' => 2]),
            'ar.topic_description.max' => __('validation.max', ['attribute' => 'topic description', 'max' => 1000]),
        ];
    }
}
