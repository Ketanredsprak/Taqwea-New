<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PaymentCartRequest extends FormRequest
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
            "card_number" => 'required|numeric',
            "exp_month" => 'required|numeric',
            "exp_year" => 'required|numeric',
            "card_cvv" => 'required|numeric',
            "card_holder_name" => 'required|string|min:2|max:50'
        ];
    }
}
