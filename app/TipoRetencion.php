<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class TipoRetencion extends Model
{
    protected $table = 'tipo_retenciones';

    protected $fillable = [
        'nombre',
        'alicuota'
    ];
}