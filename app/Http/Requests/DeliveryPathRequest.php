<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryPathRequest extends FormRequest
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
            'school'          => 'required',
            'municipality_id' => 'required',
            'path_id'         => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'school.required'          => 'La escuela es obligatoria',
            'municipality_id.required' => 'La alcaldía es obligatoria',
            'path_id.required'         => 'La ruta es obligatoria',
        ];

        return $messages;

    }
}
