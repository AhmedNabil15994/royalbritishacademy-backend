<?php

namespace Modules\Course\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title.*'                           => 'required',
            'description.*'                     => 'nullable',
            // 'level_id'                          => 'sometimes|exists:levels,id',
            'trainer_id'                        => 'nullable|exists:users,id',
            'image'                             => 'required|image|max:4098',
            // 'extra_attributes.gender'           => 'required|array|in:male,female',
            'price'                             => 'required|numeric',
            'category_id'                       => 'required|exists:categories,id',
            'extra_attributes.start_date'       => 'required_if:is_live,on',
            'extra_attributes.end_date'         => 'required_if:is_live,on',
            'extra_attributes.duration'         => 'required_if:is_live,on',
        ];

        if ($this->isMethod('PUT')) {
            $rules['image'] = 'sometimes';
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
