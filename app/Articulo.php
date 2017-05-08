<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    public function subrubro()
    {
        return $this->belongsTo(Subrubro::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function compro_item()
    {
        return $this->hasMany(ComproItem::class);
    }

    protected $fillable  = ['marca_id',
        'subrubro_id',
        'codigo',
        'codigo_fabrica',
        'codigo_auxiliar',
        'nombre',
        'nombre_reducido',
        'lleva_stock',
        'costo',
        'punto_pedido',
        'bajo_minimo',
        'activo',
        'motivo'];

}
