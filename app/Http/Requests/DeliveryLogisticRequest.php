<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryLogisticRequest extends FormRequest
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
            'school'           => 'required',
            'delivery_team_id' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'school.required'           => 'La escuela es obligatoria',
            'delivery_team_id.required' => 'El equipo de reparto es obligatorio',
        ];
        return $messages;

    }
}
