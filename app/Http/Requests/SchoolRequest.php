<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
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
    {   //dd($this->request->all());
        $rules = [
            'name'            => 'required',
            'dif_key'         => 'required',
            'municipality_id' => 'required',
            'men'             => 'required',
            'women'           => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'name.required'            => 'El campo Escuela es obligatorio.',
            'dif_key.required'         => 'El campo Clave DIF es obligatorio.',
            'municipality_id.required' => 'La alcaldía es obligatoria.',
            'men.required'             => 'El número de alumnos es obligatorio.',
            'women.required'           => 'El número de alumnas es obligatorio.',
        ];
        return $messages;

    }
}
