<?php

namespace Modules\Order\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        if (!auth()->check()) {
            return     [
                'name'               => 'required',
                'mobile'             => 'required|unique:users,mobile|phone:AUTO',
                'email'              => 'required|email|unique:users,email',
                'password'           => 'required|confirmed|min:6',
            ];
        }

        return [];
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
