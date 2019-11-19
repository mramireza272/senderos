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
use App\InterseccionSobseMejoramiento;
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
        $alcaldias = $senderos->sortBy('alcaldia')->pluck('alcaldia')->unique()->values()->filter(function($i){
            return $i != " ";
        });
        $responsables = $senderos->sortBy('responsable')->pluck('responsable')->unique()->values();
        $statuses = $senderos->sortBy('estatus')->pluck('estatus')->unique()->values();
        return view('home',compact('polygons','senderos','alcaldias','responsables','statuses'));
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
        $interseccion = InterseccionSobseMejoramiento::select(\DB::raw('ST_AsGeoJSON(geom) as geo'), 'tipo','estatus','num','nombre','ubicacion','ubicacion2','long')
                            ->get()
                            ->map(function($i) use(&$idFeatures){
                                $id = 'mun_'.str_random(10);
                                $idFeatures['municipality'][] = $id; 
                                return [
                                    'type'    => 'Feature',
                                    'id'      => $id,
                                    'properties' => [
                                        'fillOpacity'=> '0.35',
                                        'Description' => 'Interseccion',
                                        'perfil' => 'Intersección SOBSE - Mejoramiento',
                                        'tipo' => $i->tipo,
                                        'estatus' => $i->estatus,
                                        'num' => $i->num,
                                        'nombre' => $i->nombre,
                                        'ubicacion' => $i->ubicacion,
                                        'ubicacion2' => $i->ubicacion2,
                                        'long' => $i->long,
                                    ],
                                    'geometry'  => [
                                        'type'        => 'MultiLineString',
                                        'coordinates' => json_decode($i->geo)->coordinates
                                    ],

                                ];
                            })->toArray();
        $sobse = SenderoSobse::select(\DB::raw('ST_AsGeoJSON(geom) as geo'), 'tipo','estatus','num','nombre','ubicacion','ubicacion2','long')
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
                                        'perfil' => 'Senderos SOBSE',
                                        'tipo' => $i->tipo,
                                        'estatus' => $i->estatus,
                                        'num' => $i->num,
                                        'nombre' => $i->nombre,
                                        'ubicacion' => $i->ubicacion,
                                        'ubicacion2' => $i->ubicacion2,
                                        'long' => $i->long,
                                    ],
                                    'geometry'  => [
                                        'type'        => 'MultiLineString',
                                        'coordinates' => json_decode($i->geo)->coordinates
                                    ],

                                ];
                            })->toArray();

        $camaras = SenderoCamaras::select(\DB::raw('ST_AsGeoJSON(geom) as geo'), 'nombre','tipo_p')
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
                                        'nombre' => $i->tipo_p,
                                    ],
                                    'geometry'  => [
                                        'type'        => 'Point',
                                        'coordinates' => json_decode($i->geo)->coordinates
                                    ],

                                ];
                            })->toArray();

        $mejoramiento = SenderoMejoramiento::select(\DB::raw('ST_AsGeoJSON(geom) as geo'), 'nomvial','sentido','tipovial')
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
                                        'perfil' => 'Senderos Mejoramiento',
                                        'nomvial' => $i->nomvial,
                                        'sentido' => $i->sentido,
                                        'tipovial' => $i->tipovial,
                                    ],
                                    'geometry'  => [
                                        'type'        => 'MultiLineString',
                                        'coordinates' => json_decode($i->geo)->coordinates
                                    ],

                                ];
                            })->toArray();

        $polygons = json_encode([
            'type'     => 'FeatureCollection',
            'features' => array_merge($sobse,$alcaldias,$camaras,$mejoramiento,$interseccion),
        ]);

        return $polygons;
    }

    public function filtros(Sendero $senderos, Request $request){
        if(!is_null($request->responsable)){
            $senderos = $senderos->where('responsable','like','%'.$request->responsable.'%');
        }
        if(!is_null($request->alcaldia)){
            $senderos = $senderos->where('alcaldia','like','%'.$request->alcaldia.'%');
        }
        if(!is_null($request->estatus)){
            $senderos = $senderos->where('estatus','like','%'.$request->estatus.'%');
        }
        $senderos = $senderos->get();
        return $senderos;
    }

}
