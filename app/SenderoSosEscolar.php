<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SenderoSosEscolar extends Model
{
    protected $connection = 'map';
    protected $table = 'escolaressos';
}
