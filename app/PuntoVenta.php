<?php

namespace App;

use App\Events\PuntoVentaCreated;
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

    protected $events = ['created' => PuntoVentaCreated::class];
}
