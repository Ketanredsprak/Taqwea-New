<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class CreateBookingRequest extends ApiRequest
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
        $rule  = [
            //'class_id' => 'required',
            'student_id' => 'required',
            'booking_total' => 'required|numeric',
            'transaction_fees' => 'required|numeric',
            'payment_method' => 'required',
            'card_type' => 'required_if:payment_method,direct_payment',
        ];
        if (isset($this->class_id)) {
            $rule['class_id'] = 'required';
        } else {
            $rule['blog_id'] = 'required';
        }
        return $rule;
    }

    /**
     * Method messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'card_type.required_if' => __('validation.select_required', ['attribute' => 'card type']),
        ];
    }
}
