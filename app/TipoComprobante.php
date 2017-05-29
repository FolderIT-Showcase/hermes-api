<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class);
    }

    public function contador()
    {
        return $this->hasOne( Contador::class);
    }
}
