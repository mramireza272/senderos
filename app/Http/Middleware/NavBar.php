<?php

namespace App\Http\Middleware;

use App\Structure;
use Closure;

class NavBar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*$current = url('/');
        $dependencia = Structure::select('structure')->where('url', $current)->get();
        if($dependencia->isNotEmpty()){
            \Session::put('Current.dependencia',$dependencia->first()->structure);
        } else
        \Session::put('Current.dependencia', "Ciudad de México");*/
        
        return $next($request);
    }
}
