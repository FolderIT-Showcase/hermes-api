<?php

namespace App\Listeners;

use App\CtaCteCliente;
use App\Events\ComprobanteCreated;

class RegistrarEnCtaCteCliente
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ComprobanteCreated  $event
     * @return void
     */
    public function handle(ComprobanteCreated $event)
    {
        $comprobante = $event->comprobante;
        if (str_is('FC*', $comprobante->tipo_comprobante->codigo))
        {
            $ctaCteCliente = new CtaCteCliente();

            $ctaCteCliente->cliente_id = $comprobante->cliente_id;
            $ctaCteCliente->fecha = $comprobante->fecha ;
            $ctaCteCliente->comprobante_id = $comprobante->id;
            $ctaCteCliente->tipo_comprobante_id = $comprobante->tipo_comprobante_id;
            $ctaCteCliente->descripcion = $comprobante->tipo_comprobante->codigo . '-';
            $ctaCteCliente->debe = $comprobante->importe_total;
            $ctaCteCliente->haber = 0.00;

            $ctaCteCliente->save();
        }
    }
}
