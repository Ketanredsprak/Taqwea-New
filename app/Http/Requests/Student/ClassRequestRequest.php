<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ClassRequestRequest extends FormRequest
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
            'level_id' => 'required',
            // 'class_type' => 'required',
            // 'subject_id' => 'required',
            // 'preferred_gender' => 'required',
            // 'grade_id' => 'required',
             'class.*.date' => 'required_if:class_type,==,Multiple',
            // 'number_of_class' => 'required',
            'class_duration' => 'required',
            'class_time' => 'required',
            // 'class.*.end_time' => 'required',
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
            'level_id.required' => __('validation.required', ['attribute' => 'Class Level']),
            'class_type.required' => __('validation.required', ['attribute' => 'Class Type']), 
            'subject_id.required' => __('validation.required', ['attribute' => 'Subject']),  
            'preferred_gender.required' => __('validation.required', ['attribute' => 'Gender']),   
            'grade_id.required' => __('validation.required', ['attribute' => 'Grade']),   
            'class.*.date.required' => __('validation.required', ['attribute' => 'Class Date']),  
            // 'number_of_class.required' => __('validation.required', ['attribute' => 'Number Class']), 
            'class_duration.required' => __('validation.required', ['attribute' => 'Class Duration']), 
            'class_time.required' => __('validation.required', ['attribute' => 'Class Time']),   
            // 'class.*.end_time.required' => __('validation.required', ['attribute' => 'Class End Time']),   
        ];
    }
}
