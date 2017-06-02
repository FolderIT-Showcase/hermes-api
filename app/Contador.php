<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contador extends Model
{
    protected $table = 'contadores';

    public function tipo_comprobante()
    {
        return $this->belongsTo(TipoComprobante::class);
    }

}
