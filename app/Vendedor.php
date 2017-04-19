<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
	protected $table = 'vendedores';
	
    //
    public function zona()
    {
        return $this->belongsTo('Zona');
    }

    public function clientes()
    {
        return $this->hasMany('Cliente');
    }

    protected $fillable  = ['nombre', 'zona_id', 'comision'];
}