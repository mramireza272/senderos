<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BufferCaminaSegura extends Model
{
	protected $connection = 'map';
	protected $table = 'buffer_500m_camina_segura';
}
