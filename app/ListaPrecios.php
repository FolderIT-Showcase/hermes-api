<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaPrecios extends Model
{
    public function listaPrecioItem()
    {
        return $this->hasMany(ListaPrecioItem::class, 'lista_id');
    }

    protected $fillable  = ['nombre', 'porcentaje', 'activo'];
}
