<?php

namespace Modules\Semester\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SemesterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
                // handle creates
            case 'post':
            case 'POST':

                return [
                    'title.*'         => 'required',
                ];

                //handle updates
            case 'put':
            case 'PUT':
                return [
                    'title.*'        => 'required',
                ];
        }
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
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"]  =
                __('semester::dashboard.semesters.validation.title.required') . ' - ' . $value['native'] . '';


            $v["description." . $key . ".required"]  =
                __('semester::dashboard.semesters.validation.description.required') . ' - ' . $value['native'] . '';
        }

        return $v;
    }
}
