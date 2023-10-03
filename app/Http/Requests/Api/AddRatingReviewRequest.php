<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\ApiRequest;

class AddRatingReviewRequest extends ApiRequest
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
            'class_id' => 'sometimes|integer|exists:class_webinars,id',
            'from_id' => 'required|integer|exists:users,id',
            'to_id' => 'required|integer|exists:users,id',
            'rating' => 'required|numeric',
        ];
    }
}
