<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;
use App\User;

class Helper extends Controller
{
    

    public function menuDetail(Request $request){
    	$menu = Menu::select('id','description')
    				->where('id',$request->menu_id)
    				->with('products')
    				->first();

    	return $menu;
    }

    public function dayString($day){
    	switch($day){
    		case 1: return 'Lunes';
    		case 2: return 'Martes';
    		case 3: return 'Miércoles';
    		case 4: return 'Jueves';
    		case 5: return 'Viernes';
            case 6: return 'Sábado';
    	}
    }

    public function availableDrivers(){
        $users = User::select('users.*')
                    ->where('users.active',true)
                    /*->leftJoin('delivery_logistics',function($join){
                        $join->on('users.id','=','delivery_logistics.driver_delivery_man')
                             ->where('delivery_logistics.active',true);    
                    })
                    ->whereNull('delivery_logistics.driver_delivery_man')*/
                    ->orderBy('users.name')
                    ->get();

        return ['html' => \View::make('DeliveryLogistic.availableDrivers')->with(compact('users'))->render()];
    }
}
