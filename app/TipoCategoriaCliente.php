<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCategoriaCliente extends Model
{
    protected $table = 'tipo_categoria_cliente';

    public function clientes()
    {
        return $this->hasMany('Cliente');
    }
}
