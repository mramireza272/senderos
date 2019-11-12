<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\SenderoSobse;
use App\SenderoCamaras;
use App\SenderoMejoramiento;
use App\MunicipalityMap;
use App\Sendero;
//log
use App\Events\EventUserLog;
use App\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $event;
    public function __construct()
    {
        $this->middleware('auth');
        $this->event = collect(['app'=> 'web', 'controller' => 'Inicio', 'active'=> true, 'host' => url()->current(), 'remote_ip' => \Request::getClientIp(), 'module' => 'Senderos']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->event->put('user_id', auth()->user()->id);
        $this->event->put('type', 'Inicio');
        event(new EventUserLog($this->event));

        $polygons = $this->getlayers();
        $senderos = Sendero::get();
        return view('home',compact('polygons','senderos'));
    }

    public function menu(){
        return \View::make('home');
    }

    public function getlayers(){
        $alcaldias = MunicipalityMap::select(\DB::raw('ST_AsGeoJSON(wkb_geometry) as geo'), 'name')
                                        ->where('entidad',9)
                                        ->get()
                                        ->map(function($i) use(&$idFeatures){
                                            $id = 'mun_'.str_random(10);
                                            $idFeatures['municipality'][] = $id; 
                                            return [
                                                'type'    => 'Feature',
                                                'id'      => $id,
                                                'properties' => [
                                                    'fillOpacity'=> '0.35',
                                                    'Description' => 'Alcaldia',
                                                    'Alcaldia' => $i->name,
                                                ],
                                                'geometry'  => [
                                                    'type'        => 'Polygon',
                                                    'coordinates' => json_decode($i->geo)->coordinates[0]
                                                ],

                                            ];
                                        })->toArray();
        $sobse = SenderoSobse::select(\DB::raw('ST_AsGeoJSON(geom) as geo'), 'tipo')
                            ->get()
                            ->map(function($i) use(&$idFeatures){
                                $id = 'mun_'.str_random(10);
                                $idFeatures['municipality'][] = $id; 
                                return [
                                    'type'    => 'Feature',
                                    'id'      => $id,
                                    'properties' => [
                                        'fillOpacity'=> '0.35',
                                        'Description' => 'SOBSE',
                                        'tipo' => 'Senderos SOBSE',
                                        'Alcaldia' => $i->tipo,
                                    ],
                                    'geometry'  => [
                                        'type'        => 'MultiLineString',
                                        'coordinates' => json_decode($i->geo)->coordinates
                                    ],

                                ];
                            })->toArray();

        $camaras = SenderoCamaras::select(\DB::raw('ST_AsGeoJSON(geom) as geo'), 'nombre')
                            ->get()
                            ->map(function($i) use(&$idFeatures){
                                $id = 'mun_'.str_random(10);
                                $idFeatures['municipality'][] = $id; 
                                return [
                                    'type'    => 'Feature',
                                    'id'      => $id,
                                    'properties' => [
                                        'fillOpacity'=> '0.35',
                                        'Description' => 'Camaras',
                                        'tipo' => 'Senderos Cámaras',
                                        'nombre' => $i->nombre,
                                    ],
                                    'geometry'  => [
                                        'type'        => 'Point',
                                        'coordinates' => json_decode($i->geo)->coordinates
                                    ],

                                ];
                            })->toArray();

        $mejoramiento = SenderoMejoramiento::select(\DB::raw('ST_AsGeoJSON(geom) as geo'), 'nomvial')
                            ->get()
                            ->map(function($i) use(&$idFeatures){
                                $id = 'mun_'.str_random(10);
                                $idFeatures['municipality'][] = $id; 
                                return [
                                    'type'    => 'Feature',
                                    'id'      => $id,
                                    'properties' => [
                                        'fillOpacity'=> '0.35',
                                        'Description' => 'Mejoramiento',
                                        'tipo' => 'Senderos Mejoramiento',
                                        'nombre' => $i->nomvial,
                                    ],
                                    'geometry'  => [
                                        'type'        => 'MultiLineString',
                                        'coordinates' => json_decode($i->geo)->coordinates
                                    ],

                                ];
                            })->toArray();
        //dd($camaras);
        $polygons = json_encode([
            'type'     => 'FeatureCollection',
            'features' => array_merge($sobse,$alcaldias,$camaras,$mejoramiento),
        ]);

        return $polygons;
    }

}
