<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CommissionRequest Class
 */
class CommissionRequest extends FormRequest
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
        $regex =  config('constants.two_decimal_regex');
        return [
            'vat' => 'required|max:100|min:1|regex:'.
            $regex,
            'transaction_fee' => 'required|max:100|min:1|regex:'.
            $regex,
            'commission' => 'required|max:100|min:1|regex:'.
            $regex,
        ];
    }

    
}
