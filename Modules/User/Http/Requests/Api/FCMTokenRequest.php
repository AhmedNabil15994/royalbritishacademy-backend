<?php

namespace Modules\User\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FCMTokenRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
               'firebase_token' => 'required',
               'device_type'    => 'required|in:ios,android,desktop',
            ];
    }

    public function authorize()
    {
        return true;
    }
}
