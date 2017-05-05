<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendedor extends Model
{
	protected $table = 'vendedores';
	
    //
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    protected $fillable  = ['nombre', 'zona_id', 'comision'];
}