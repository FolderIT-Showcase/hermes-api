<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class TipoComprobanteCompra extends Model
{
    protected $table = 'tipo_comprobantes_compras';

    public function comprobantes_compra()
    {
        return $this->hasMany(ComprobanteCompra::class);
    }

}