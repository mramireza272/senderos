<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class DataMigrater extends Controller
{

	public function __construct()
    {   
        $this->middleware('auth');
    }
    
	public static function ExcelArray($excel, $url=null, $sheet=null){
		$reader = new Xlsx();
		if(is_null($url)){
			$spreadsheet = $reader->load(storage_path('initial/'.$excel));
		}else
		{
			$spreadsheet = $reader->load(storage_path($url.'/'.$excel));
		}
		
		if(is_null($sheet)){	
			$worksheet = $spreadsheet->getActiveSheet();
		}else{
			$worksheet = $spreadsheet->getSheet($sheet);
		}
		$array  = [];
		$header = [];
		$head   = true;

		foreach ($worksheet->getRowIterator() as $row) {
		    $cellIterator = $row->getCellIterator();
		    $cellIterator->setIterateOnlyExistingCells(FALSE); 
		    
		    $line = [];
		    $i = 0;
		    foreach ($cellIterator as $cell) {
		    	$val = $cell->getValue();
		    	if($head){
		    		$header[] = $val;
		    	}else{
		    		
		    		$line[$header[$i]] = ($val === 'NULL')?null:$val;
		    	}
		    	$i++;
		    }

		    if($head){
		    	$head    = false;
		    }else{
		    	$line['created_at'] = date('Y-m-d H:i:s');
		    	$line['updated_at'] = date('Y-m-d H:i:s');
		    	//$line['active'] = true;
		    	$array[] = $line;
		    }
		    
		}

		return $array;
	}

	public static function DataToExcel($query,$name){
		$header = [collect($query->first())->keys()];
        $all = collect($header)->merge($query->toArray());
		$query = $all->toArray();
		$spreadsheet = new Spreadsheet();
		$Excel_writer = new Xlsx($spreadsheet);
		$spreadsheet->setActiveSheetIndex(0);
		$activeSheet = $spreadsheet->getActiveSheet()->fromArray($query,null,'A1');
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
		$writer->save(storage_path("xlsx/structures.xlsx"));	
		return 'xlsx/'.$name;

	}

}
