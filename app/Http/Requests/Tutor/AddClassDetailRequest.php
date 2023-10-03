<?php

namespace App\Http\Requests\Tutor;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add class validations
 */
class AddClassDetailRequest extends FormRequest
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
            'duration' => 'required',
            'class_date' => 'required',
            'class_time' => 'required',
            'total_fees' => 'required_if:hourly_fees,null|nullable|numeric|min:50',
            'hourly_fees' => 'nullable|numeric|min:50',
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
            'duration.required' => __('validation.select_required'),
            'class_date.required' => __('validation.required'),
            'class_time.required' => __('validation.required'),
            'total_fees.required_if' => __('validation.required_if', ['value' => trans('labels.value')]),
        ];
    }
}
