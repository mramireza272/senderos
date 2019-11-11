<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryTruckRequest extends FormRequest
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
            'plates' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'plates.required' => 'Las placas son obligatorias',
        ];
        return $messages;

    }
}
