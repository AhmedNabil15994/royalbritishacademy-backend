<?php

namespace Modules\Exam\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UserExamRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'answers'                    =>'required',
            'answers.*.question'         =>'required|integer|exists:questions,id',
            'answers.*.answer'           =>'sometimes|integer|exists:question_answers,id',
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
