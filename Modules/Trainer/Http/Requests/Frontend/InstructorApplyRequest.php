<?php

namespace Modules\Trainer\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class InstructorApplyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                  'name'            => 'required',
                  'mobile'            => 'required|numeric|unique:applies,mobile|phone:AUTO',
                  'email'           => 'required|unique:applies,email',
                  'country_id'      => 'required|exists:countries,id',
                  'cv'              => 'required|file|max:2048',
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
