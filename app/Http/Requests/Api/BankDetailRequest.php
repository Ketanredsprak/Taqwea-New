<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class BankDetailRequest extends ApiRequest
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
            'beneficiary_name' => 'required',
            'account_number' => 'required',
            'bank_code' => 'required',
            'address' => 'nullable|max:191',
        ];
    }
}
