<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
	protected $table = 'localidades';
	
    //
    public function domicilios()
    {
        return $this->hasMany('Domicilio');
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }
}
