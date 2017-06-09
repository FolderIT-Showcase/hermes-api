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
        if (!str_is('PR*', $comprobante->tipo_comprobante->codigo))
        {
            $ctaCteCliente = $this->CrearCtaCte($comprobante);

            switch (substr($comprobante->tipo_comprobante->codigo, 0, 2)) {
                case 'FC':case 'ND':
                    $ctaCteCliente->debe = $comprobante->importe_total;
                    $ctaCteCliente->haber = 0.00;
                    break;
                case 'NC':
                    $ctaCteCliente->debe = 0.00;
                    $ctaCteCliente->haber = $comprobante->importe_total;
                    break;
                default:
            }
            $ctaCteCliente->save();
        }
    }

    /**
     * @param $comprobante
     * @return CtaCteCliente
     */
    protected function CrearCtaCte($comprobante): CtaCteCliente
    {
        $ctaCteCliente = new CtaCteCliente();

        $ctaCteCliente->cliente_id = $comprobante->cliente_id;
        $ctaCteCliente->fecha = $comprobante->fecha;
        $ctaCteCliente->comprobante_id = $comprobante->id;
        $ctaCteCliente->tipo_comprobante_id = $comprobante->tipo_comprobante_id;
        $ctaCteCliente->descripcion = $comprobante->tipo_comprobante->codigo . '-';

        return $ctaCteCliente;
    }
}
