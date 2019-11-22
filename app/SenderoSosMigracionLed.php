<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SenderoSosMigracionLed extends Model
{
    protected $connection = 'map';
    protected $table = 'migracionledsos';
}
