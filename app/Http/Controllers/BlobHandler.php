<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class BlobHandler extends Controller
{
    
    public function __construct()
    {   
        $this->middleware('auth');
    }

	CONST DESTINATION = [
		'pi' => [
			'class' => '\App\FilePathIncident',
            'conn'  => 'DB_CONNECTION',
            'db'    => 'DB_DATABASE',
            'usr'   => 'DB_USERNAME',
            'pass'  => 'DB_PASSWORD',
			'table' => 'file_path_incidents',
			'field' => 'data',
			'key'   => 'id',
			'mime'  => 'mime',
			'name'  => 'name_file'
 		],

	];

	public static function setFile($destination,$file,$id){
		$con     = pg_connect("host=".env('DB_HOST') ." dbname=". env(SELF::DESTINATION[$destination]['db']) .
							  " user=".env(SELF::DESTINATION[$destination]['usr']) .
                              " password=" . env(SELF::DESTINATION[$destination]['pass']) 
							  )
            		or die ("No se puede conectar al servidor");
        //$img     = fopen($file->getRealPath(), 'rb') or die("No se puede obtener el archivo");
        $data    = $file;//fread($img, filesize($file->getRealPath()));
        $es_data = pg_escape_bytea($data);
        
        //fclose($img);
        //$mime = $file->getClientMimeType();
        //$name = $file->getClientOriginalName();
        $query = "UPDATE ".SELF::DESTINATION[$destination]['table']." ".
        		 "SET ".SELF::DESTINATION[$destination]['field']." = '$es_data' ".
        		 		//SELF::DESTINATION[$destination]['mime'] ." = '$mime', ".
        		 		//SELF::DESTINATION[$destination]['name'] ." = '$name' ".
        		 "WHERE ".SELF::DESTINATION[$destination]['key']." = $id";
        pg_query($con, $query); 
        pg_close($con);
	}

	public static function getFile($destination,$id){
		$class = SELF::DESTINATION[$destination]['class'];
        $field = SELF::DESTINATION[$destination]['field'];
		$file = $class::find($id);
        $data = stream_get_contents($file->$field);
        return [
        	'data' => $data,
        	'mime' => $file->mime,
        	'name' => $file->name
        ];
	}
}