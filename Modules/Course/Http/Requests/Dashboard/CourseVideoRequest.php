<?php

namespace Modules\Course\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CourseVideoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                    'title.*'          => 'required',
                    'description.*'    => 'required',
                    'course_lesson_id'   => 'required',
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

    public function messages()
    {
        $v = [
            'lesson_id.required'   => __('course::dashboard.lessons.validation.lesson_id.required'),
        ];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title.".$key.".required"]  = __('course::dashboard.courses.validation.title.required').' - '.$value['native'].'';

            $v["title.".$key.".unique"]    = __('course::dashboard.courses.validation.title.unique').' - '.$value['native'].'';

            $v["description.".$key.".required"]  = __('course::dashboard.courses.validation.description.required').' - '.$value['native'].'';
        }

        return $v;
    }
}
