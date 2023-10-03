<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class for add wallet amount validations
 */
class RedeemRequest extends FormRequest
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
            'points' => 'required|numeric|regex:/^[1-9]+[0-9]*00$/|min:100|check_max_points',
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
            'points.check_max_points' => trans('validation.check_max_points'),
            'points.regex' => trans('validation.point_regex'),
        ];
    }
}
