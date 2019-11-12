<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MunicipalityMap extends Model
{
    protected $connection = 'map';
	protected $table = 'municipio';
}
