<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * SubscriptionEditRequest
 */
class SubscriptionEditRequest extends FormRequest
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
            'subscription_name' => 'required|',
            'subscription_description' => 'required',
            'allow_booking' => 'required|integer',
            'class_hours' => 'required|integer',
            'webinar_hours' => 'required|integer',
            'featured' => 'required',
            'commission' => 'required|integer',
            'blog' => 'required|integer',
            'duration' => 'required_if:default_plan,==,No|integer',
            'amount' => 'required_if:default_plan,==,No|integer',
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
            'updateField.*.duration.required' => __(
                'validation.required',
                ['attribute' => 'required duration field']
            ),
            'updateField.*.amount.required' => __(
                'validation.required',
                ['attribute' => 'required amount field']
            ),
            'duration.required_if' => 'The duration field is required.',
            'amount.required_if' => 'The duration field is required.',
        ];
    }
}
