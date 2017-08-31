<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedioPago extends Model
{
    protected $table = 'medios_pago';

    protected $fillable  = [ 'nombre',
        'orden'
    ];
}
