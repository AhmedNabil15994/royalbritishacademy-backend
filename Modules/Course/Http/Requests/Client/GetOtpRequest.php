<?php

namespace Modules\Course\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class GetOtpRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'type'      =>'required|in:course_intro,lesson_video',
           'model_id'      =>'required',
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
