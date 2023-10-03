<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TopUpRequest extends FormRequest
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
            'class_per_hours_price' => 'required|integer|min:1',
            'webinar_per_hours_price' => 'required|integer|min:1',
            'blog_per_hours_price' => 'required|integer|min:1',
            'is_featured_price' => 'required|integer|min:1',
        ];
    }
}
