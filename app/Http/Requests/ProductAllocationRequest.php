<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductAllocationRequest extends FormRequest
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
        //dd($this->all());
        $different = false;

        if(isset($this->week)) {
            $size = count($this->week);

            if(count(array_unique(array_filter($this->week))) < $size) {
                $different = true;
            }
        }

        $rules = [
            'menu.1' => 'required|array|min:1|max:5',
            'menu.2' => 'required|array|min:1|max:5',
            'menu.3' => 'required|array|min:1|max:5',
            'menu.4' => 'required|array|min:1|max:5',
        ];

        if(!isset($this->all_schools)) {
            $rules = array_add($rules, 'municipality_id', 'required');
            $rules = array_add($rules, 'school_id', 'required');
        }

        if($different) {
            $rules = array_add($rules, 'week.*', 'different:week.*');
        } else {
            $rules = array_add($rules, 'week', 'required');
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => ':attribute es obligatoria',
            'week.*.required' => ':attribute es obligatoria',
            'menu.*.required' => ':attribute es obligatorio',
            'menu.*.min' => ':attribute debe contener al menos :min elementos',
            'menu.*.max' => ':attribute debe contener hasta :max elementos',
            'different' => 'Las Semanas deben ser diferentes',
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
            'week.1' => 'La Semana 1',
            'week.2' => 'La Semana 2',
            'week.3' => 'La Semana 3',
            'week.4' => 'La Semana 4',
            'menu.1' => 'El Menú de la Semana 1',
            'menu.2' => 'El Menú de la Semana 2',
            'menu.3' => 'El Menú de la Semana 3',
            'menu.4' => 'El Menú de la Semana 4',
            'municipality_id' => 'La Alcaldía',
            'school_id' => 'La Escuela',
        ];
    }
}
