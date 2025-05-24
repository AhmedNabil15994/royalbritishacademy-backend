<?php

namespace Modules\Exam\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'question.*'=>'required',
                'answers.*'=>'required',
                'exam_id'=>'required|exists:exams,id',
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
