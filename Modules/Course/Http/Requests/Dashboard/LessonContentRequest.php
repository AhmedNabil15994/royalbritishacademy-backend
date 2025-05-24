<?php

namespace Modules\Course\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class LessonContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [
            'title.*'       => 'required',
            'course_id'     => 'required|exists:courses,id',
            'type'          => 'required|in:exam,resource,video',
            'exam_id'       => 'nullable|required_if:type,exam',
            'resource'      => 'nullable|required_if:type,resource|mimes:pdf',
            'video'    => 'required',
            'order'         => 'nullable|required|integer',
            'resources' => 'nullable|array',
            'resources.*' => 'mimes:jpeg,png,jpg,gif,svg,doc,pdf,docx|max:30048',
        ];

        if ($this->isMethod('PUT')) {

            $rules['video']     = 'sometimes';
        }

        return $rules;
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



/**
 * model_type $model->type (old_type)
 * if old_type== 'video'&&type='video'
 * then video sometimes and delete if there is new
 * if old_type== 'resource'&&type='resource'
 * then resource sometimes
 * and delete if there is new
 * if old_type !== type
 * it mean post validation
 */
