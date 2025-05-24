<?php

namespace Modules\Authentication\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required',
            'mobile'     => 'required|unique:users,mobile|numeric|digits_between:8,8',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed|min:6',
            // 'category_id'=> 'required',
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
            'category_id.required'         =>   __('authentication::api.register.validation.category_id.required'),
            'name.required'         =>   __('authentication::api.register.validation.name.required'),
            'mobile.required'       =>   __('authentication::api.register.validation.mobile.required'),
            'mobile.unique'         =>   __('authentication::api.register.validation.mobile.unique'),
            'mobile.numeric'        =>   __('authentication::api.register.validation.mobile.numeric'),
            'mobile.digits_between' =>   __('authentication::api.register.validation.mobile.digits_between'),
            'email.required'        =>   __('authentication::api.register.validation.email.required'),
            'email.unique'          =>   __('authentication::api.register.validation.email.unique'),
            'email.email'           =>   __('authentication::api.register.validation.email.email'),
            'password.required'     =>   __('authentication::api.register.validation.password.required'),
            'password.min'          =>   __('authentication::api.register.validation.password.min'),
            'password.confirmed'    =>   __('authentication::api.register.validation.password.confirmed'),
        ];

        return $v;
    }
}
