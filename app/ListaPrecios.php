<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaPrecios extends Model
{
    protected $fillable  = ['nombre', 'porcentaje', 'activo'];
}
