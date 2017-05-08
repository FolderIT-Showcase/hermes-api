<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    public function vendedores()
    {
        return $this->hasMany(Vendedor::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    protected $fillable  = ['nombre'];
}
