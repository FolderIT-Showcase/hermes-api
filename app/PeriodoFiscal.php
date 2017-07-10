<?php

namespace app;


use Illuminate\Database\Eloquent\Model;

class PeriodoFiscal extends Model
{
    protected $table = 'periodos_fiscales';

    protected $fillable = [
        'mes',
        'anio',
        'abierto'
    ];
}