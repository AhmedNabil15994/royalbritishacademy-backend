<?php

namespace Modules\Authentication\Http\Requests\Frontend;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|exists:users,email',
            'token'     => [
                'required',
                Rule::exists("password_resets")->where(function ($query) {
                    $query->where("token", $this->token)->where("email", $this->email);
                }),
            ],
            'password'  => 'required|confirmed|min:6',
        ];
    }
    // 'exists:password_resets,token'
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
