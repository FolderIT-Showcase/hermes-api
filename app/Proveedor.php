<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_responsable',
        'cuit',
        'telefono',
        'celular',
        'email',
        'activo',
        'motivo'
    ];

}