<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaPrecioItem extends Model
{
    public function listaPrecios()
    {
        return $this->belongsTo(ListaPrecios::class, 'lista_id');
    }

    public function articulo()
    {
        return $this->hasOne(Articulo::class);
    }

    protected $fillable  = ['lista_id', 'articulo_id', 'precio_costo', 'precio_venta'];
}
