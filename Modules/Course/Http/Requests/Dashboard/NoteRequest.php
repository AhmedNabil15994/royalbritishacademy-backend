<?php

namespace Modules\Course\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title.*'                           => 'required',
            'desc.*'                            => 'nullable',
            'trainer_id'                        => 'nullable|exists:users,id',
            'image'                             => 'required|image|max:4098',
            'price'                             => 'required|numeric',
            'category_id'                       => 'required|exists:categories,id',
            'pdf'                               => 'required|mimes:pdf',
        ];

        if ($this->isMethod('PUT')) {
            $rules['image'] = 'sometimes';
            $rules['pdf']   = 'sometimes';
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
}
