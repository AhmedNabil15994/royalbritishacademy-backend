<?php

namespace Modules\Authentication\Http\Requests\Frontend;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }




    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'               => 'required',
            'mobile'             => 'required|unique:users,mobile',
            'email'              => 'required|email|unique:users,email',
            'password'           => 'required|confirmed|min:6',
            // 'academic_year_id'       => 'required',
        ];
    }  
    
    public function attributes()
    {
        return [
            
            'academic_year_id' => ' السنة الدراسيىة',
        ];
    }
}
