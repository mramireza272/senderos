<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PathRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'name.required' => 'El nombre de la ruta es obligatorio',
        ];
        return $messages;

    }
}
