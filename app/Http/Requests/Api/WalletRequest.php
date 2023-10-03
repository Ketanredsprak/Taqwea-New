<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class WalletRequest extends FormRequest
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
            // 'type' => 'required|in:wallet,checkout',
            // 'transaction_id' => 'required',
            'amount' => 'required|numeric|not_in:0',
            'payment_method' => 'required|in:direct_payment',
            'card_type' => 'required_if:payment_method,direct_payment',
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
            'card_type.required_if' => __('validation.select_required', ['attribute' => 'card type']),
        ];
    }
}
