<?php

namespace Modules\Trainer\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class TrainerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules= [
                  'roles'           => 'required',
                  'name'            => 'required',
                  'mobile'          => 'required|numeric|unique:users,mobile|digits_between:8,8',
                  'email'           => 'required|unique:users,email',
                  'password'        => 'required|min:6|same:confirm_password',
                ];

        if ($this->isMethod('PUT')) {
            $rules['mobile']     = 'required|numeric|digits_between:8,8|unique:users,mobile,'.$this->trainer.',id';
            $rules['email']      = 'required|unique:users,email,'.$this->trainer.',id';
            $rules['password']   = 'nullable|min:6|same:confirm_password';
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

    public function messages()
    {
        $v = [
            'roles.required'          => __('trainer::dashboard.trainers.validation.roles.required'),
            'name.required'           => __('trainer::dashboard.trainers.validation.name.required'),
            'email.required'          => __('trainer::dashboard.trainers.validation.email.required'),
            'email.unique'            => __('trainer::dashboard.trainers.validation.email.unique'),
            'mobile.required'         => __('trainer::dashboard.trainers.validation.mobile.required'),
            'mobile.unique'           => __('trainer::dashboard.trainers.validation.mobile.unique'),
            'mobile.numeric'          => __('trainer::dashboard.trainers.validation.mobile.numeric'),
            'mobile.digits_between'   => __('trainer::dashboard.trainers.validation.mobile.digits_between'),
            'password.required'       => __('trainer::dashboard.trainers.validation.password.required'),
            'password.min'            => __('trainer::dashboard.trainers.validation.password.min'),
            'password.same'           => __('trainer::dashboard.trainers.validation.password.same'),
        ];

        return $v;
    }
}
