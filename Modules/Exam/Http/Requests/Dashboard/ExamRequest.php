<?php

namespace Modules\Exam\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title.*'=>'required',
            'degree'=>'required|integer',
            'success_degree'=>'required|integer|lte:degree',
       ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
