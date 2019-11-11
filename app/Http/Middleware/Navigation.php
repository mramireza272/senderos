<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Navigation
{
    private $menus;

    function __construct(){
        //$this->menus = [];

        $url = str_replace(url('/'),'',url()->current());
        $this->menus = [
            'Menu principal'    => [
                'url'     => url('/home'),
                'active'  => ($url == '')?' class="active-sub"':'',
                'icon'    => 'pli-home',
            ],
        ];

        if(Auth::check()){
            if(Auth::user()->hasRole(['Administrador'])){
                $this->menus['Bitácora'] = [
                    'url'     => route('bitacora.index'),
                    'active' => (strpos($url,str_replace(url('/'),'','/bitacora')) !== false)?' class="active-sub"':'',
                    'icon'   => 'pli-bulleted-list'
                ];
            }

            if(Auth::user()->hasPermissionTo('index_user')){
                $this->menus['Usuarios'] = [
                    'url'    => url('/usuarios'),
                    'active' => (strpos($url,str_replace(url('/'),'','/usuarios')) !== false)?' class="active-sub"':'',
                    'icon'   => 'pli-male-female'
                ];
            }

            if(Auth::user()->hasPermissionTo('index_roles')){
                $this->menus['Roles'] = [
                    'url'    => url('/roles'),
                    'active' => (strpos($url,str_replace(url('/'),'','/roles')) !== false)?' class="active-sub"':'',
                    'icon'   => 'pli-id-card'
                ];

                $this->menus['Permisos'] = [
                    'url'    => url('/permisos'),
                    'active' => (strpos($url,str_replace(url('/'),'','/permisos')) !== false)?' class="active-sub"':'',
                    'icon'   => 'pli-key'
                ];
            }
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $menu = collect($this->menus);
        \Session::put('Current.menu',$menu);
        return $next($request);
    }
}
