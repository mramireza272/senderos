<?php 
namespace App\Extensions;
 
use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;
use App\User;
use App\Models\Seguridad\Catalog;
use App\Models\Seguridad\Crime;
use App\Models\Seguridad\Security;
use App\Models\Seguridad\Assistant;
 
class TwigCustom extends Twig_Extension {

	private const TRANSFORM = [
		'place'      => 'Descripción del lugar donde sesionan',
		'civico'     => 'Informe Ejecutivo del Juzgado Cívico',
		'legista'    => 'Informe Ejecutivo del Médico Legista',
		'alcaldia'   => 'Informe Ejecutivo del Representante de la Alcaldía',
		'otros'      => 'Otros Asuntos',
		'especiales' => 'Asuntos Especiales',
		'acuerdos'   => 'Acuerdos',
		'mp'         => 'Informe Ejecutivo del Ministerio Público',
		'ssp'        => 'Informe Ejecutivo del Jefe de Sector SSC',
		'pdi'        => 'Informe Ejecutivo del Policía de Investigación',
		'relevantes' => 'Asuntos Relevantes',
		'jc'         => 'Informe Ejecutivo del Juzgado Cívico',
	];

	public function getName() {
		// 
	}
 
	/**
	 * Functions
	 * @return void
	 */
	public function getFunctions() {
		return [
	        new Twig_SimpleFunction('auth', [$this, 'auth']),
	        new Twig_SimpleFunction('collect', [$this, 'collect']),
	        new Twig_SimpleFunction('userDetail', [$this, 'userDetail']),
	        new Twig_SimpleFunction('userInfo', [$this, 'userInfo']),
	        new Twig_SimpleFunction('can', [$this, 'can']),
	        new Twig_SimpleFunction('cannot', [$this, 'cannot']),
	        /*new Twig_SimpleFunction('checkResponseFile', [$this, 'checkResponseFile']),
	        new Twig_SimpleFunction('checkAdditionalFile', [$this, 'checkAdditionalFile']),
	        new Twig_SimpleFunction('checkClosureFile', [$this, 'checkClosureFile']),*/
	    ];
	}
 
	/**
	 * Filters
	 * @return void
	 */
	public function getFilters() {
		return [
			new Twig_SimpleFilter('varConvertion', [$this, 'varConvertion']),
			new Twig_SimpleFilter('catalogConvertion', [$this, 'catalogConvertion']),
			new Twig_SimpleFilter('crimeConvertion', [$this, 'crimeConvertion']),
			new Twig_SimpleFilter('securityConvertion', [$this, 'securityConvertion']),
			new Twig_SimpleFilter('assistantConvertion', [$this, 'assistantConvertion']),
			new Twig_SimpleFilter('dateConvertion', [$this, 'dateConvertion']),
			new Twig_SimpleFilter('jsonDecode', [$this, 'jsonDecode']),
			/*new Twig_SimpleFilter('sanatizeStatus', [$this, 'sanatizeStatus']),*/
		];
	}
	
	public function can($action, $data){
		return \Auth::user()->can($action, $data);
	}

	public function cannot($action, $data){
		return !\Auth::user()->can($action, $data);
	}

	public function auth(){
		return auth();
	}
	public function collect($var=[]){
		return collect($var);
	}

	public function varConvertion($var){
		return SELF::TRANSFORM[$var];
	}

	public function userDetail($id){
		$user = User::select('users.name','assistants.assistant')
			->where('users.id',$id)
			->join('assistants','assistants.id','=','users.assistant_id')
			->first();
			dd($user);
		return [
			'name'      => $user->name,
			'assistant' => $user->assistant
		];
	}

	public function userInfo($id){
		return User::find($id);
	}

	public function assistantConvertion($id){
		return ($id == 0)?'Representante de la Jefa de Gobierno':Assistant::find($id)->assistant;
	}

	public function crimeConvertion($id){
		return Crime::find($id)->crime;
	}

	public function securityConvertion($id){
		return Security::find($id)->security;
	}

	public function catalogConvertion($id){
		return Catalog::find($id)->name;
	}

	public function dateConvertion($date){
		return 'Ciudad de México, a '.date('d',strtotime($date)).' de '.$this->monthToString(date('m',strtotime($date))).' de '.date('Y',strtotime($date));
	}

	private function monthToString($int){
		$month = [
			'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
		];
		return $month[(int)($int-1)];
	}

	public function jsonDecode($json){ //dd(json_decode($json,true));
		return json_decode($json,true);
	}
	/*public function sanatizeStatus($string){
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
	    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
	    $string = utf8_decode($string);
	    $string = strtr($string, utf8_decode($originales), $modificadas);
	    $string = strtolower($string);
	    $string = str_replace(' ','-',$string);
	    return utf8_encode($string);
		
	}
	public function microTime($bool){
		return microtime($bool);
	}
	public function checkResponseFile($uuid){
		$documentFactory = new DocumentFactory();
		return $documentFactory->checkResponseFileExists($uuid);
	}
	public function checkAdditionalFile($uuid){
		$documentFactory = new DocumentFactory();
		return $documentFactory->checkAdditionalFileExists($uuid);
	}
	public function checkClosureFile($uuid){
		$documentFactory = new DocumentFactory();
		return $documentFactory->checkClosureFileExists($uuid);
	}
	public function dateConvertion($date){
		if(date('dmY',strtotime($date)) == date('dmY')){
			$return = date('H:i',strtotime($date)).' Hrs.';
		}else{
			$return = date('d/m/Y',strtotime($date));
		}
		return $return;
	}*/

 
}