<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name' => 'required|max:255',
            'paterno' => 'required|max:255',
            'materno' => 'max:255',
            'curp' => array('required',
                'min:18',
                'max:18',
                'regex:/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/'),
            'grade_id' => 'required',
            'group_id' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'school_id.required' => 'La Escuela es obligatoria',
            'curp.required' => 'La CURP es obligatoria',
            'required' => 'El :attribute es obligatorio',
            'max'  => 'El :attribute no debe ser mayor a :max',
            'min'  => 'El tamaño de :attribute debe ser de al menos :min',
            'regex' => 'El formato de :attribute es inválido'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'paterno' => 'Apellido Paterno',
            'materno' => 'Apellido Materno',
            'curp' => 'CURP',
            'school_id' => 'Escuela',
            'grade_id' => 'Grado',
            'group_id' => 'Grupo',
        ];
    }
}
