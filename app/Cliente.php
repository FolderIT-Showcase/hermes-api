<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function vendedor()
    {
        return $this->belongsTo(Vendedor::class);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function tipo_categoria_cliente()
    {
        return $this->belongsTo(TipoCategoriaCliente::class);
    }

    public function domicilios()
    {
        return $this->hasMany(Domicilio::class);
    }

    protected $fillable  = ['vendedor_id', 'zona_id', 'tipo_categoria_id', 'codigo', 'nombre', 'tipo_responsable', 'cuit', 'telefono', 'celular', 'email', 'activo', 'motivo'];
}