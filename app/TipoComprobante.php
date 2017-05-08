<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoComprobante extends Model
{
    public function comprobantes()
    {
        return $this->hasMany(Comprobante::class);
    }
}
