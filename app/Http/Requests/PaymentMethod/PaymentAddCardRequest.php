<?php

namespace App\Http\Requests\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

/**
 * PaymentAddCardRequest 
 */
class PaymentAddCardRequest extends FormRequest
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
            "card_number" => 'required|between:12,16',
            "card_holder_name" => 'required',
            "expired_date" => 'required',
            "card_cvv" => 'required|digits:3',
            'card_type' => 'required',
        ];
    }
}
