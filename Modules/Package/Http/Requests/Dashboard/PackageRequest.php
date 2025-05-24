<?php

namespace Modules\Package\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
            "title" => "required",
            // "title.*" => "required|unique_translation:packages,title|string|max:255",
            "description" => "nullable",
            "image" => "required|image|max:4028",
            "courses.*" => "required|exists:courses,id",
            "notes.*" => "required|exists:notes,id",
            "is_free" => "sometimes",
            "package_prices.*.subscribe_duration_desc.*" => "required",
            "package_prices.*.days_count" => "required",
            "status" => "sometimes",
        ];

        if ($this->isMethod('PUT')) {
            // $rule["title.*"] = "required|unique_translation:packages,title,{$this->package},id|string|max:255";
            $rule["image"] = "sometimes|image|max:4028";
        }

        return $rule;
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
