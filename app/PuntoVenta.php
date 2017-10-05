<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PuntoVenta extends Model
{
    protected $table = 'puntos_venta';
    public $incrementing = false;

    protected $fillable  = ['id',
        'habilitado',
        'descripcion',
        'tipo_impresion'
    ];
}
