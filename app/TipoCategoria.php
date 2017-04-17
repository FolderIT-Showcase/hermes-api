<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCategoriaCliente extends Model
{
    //
    public function clientes()
    {
        return $this->hasMany('Cliente');
    }
}
