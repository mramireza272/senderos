<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class DeliveryTeamRequest extends FormRequest
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
        \Validator::extend('not_exists', function($attribute, $value, $parameters){
            return \DB::table($parameters[0])
                ->where('active',true)
                ->where($parameters[1], '=', $value)
                ->count()==0;
        });

        $rules = [
            'delivery_truck_id'     => 'required|not_exists:delivery_teams,delivery_truck_id',
            'driver_delivery_man'   => 'required|not_exists:delivery_teams,driver_delivery_man',
            'codriver_delivery_man' => 'required|not_exists:delivery_teams,codriver_delivery_man',
        ];

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'delivery_truck_id.required'       => 'El camión es obligatorio',
            'driver_delivery_man.required'     => 'El conductor es obligatorio',
            'codriver_delivery_man.required'   => 'El acompañante es obligatorio',
            'delivery_truck_id.not_exists'     => 'El camión ya ha sido asignado',
            'driver_delivery_man.not_exists'   => 'El conductor ya ha sido asignado',
            'codriver_delivery_man.not_exists' => 'El acompañante ya ha sido asignado',
        ];
        return $messages;

    }
}
