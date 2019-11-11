<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MunicipalityDeliveryDayRequest extends FormRequest
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
            'day'             => 'required',
            'municipality_id' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'day.required'             => 'La contingencia es obligatoria',
            'municipality_id.required' => 'La alcaldía es obligatoria',
        ];

        return $messages;

    }
}
