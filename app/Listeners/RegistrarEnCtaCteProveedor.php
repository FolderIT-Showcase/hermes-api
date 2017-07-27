<?php

namespace App\Listeners;

use App\CtaCteProveedor;
use App\Events\ComprobanteCompraCreated;

class RegistrarEnCtaCteProveedor
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
     * @param  ComprobanteCompraCreated  $event
     * @return void
     */
    public function handle(ComprobanteCompraCreated $event)
    {
        $comprobante = $event->comprobante;
        $ctaCteProveedor = $this->CrearCtaCte($comprobante);

        switch (substr($comprobante->tipo_comp_compras->codigo, 0, 2)) {
            case 'FC':case 'ND':
            $ctaCteProveedor->debe = $comprobante->importe_total;
            $ctaCteProveedor->haber = 0.00;
            break;
            case 'NC':
                $ctaCteProveedor->debe = 0.00;
                $ctaCteProveedor->haber = $comprobante->importe_total;
                break;
            default:
        }
        $ctaCteProveedor->save();
    }

    /**
     * @param $comprobante
     * @return CtaCteProveedor
     */
    protected function CrearCtaCte($comprobante): CtaCteProveedor
    {
        $ctaCteProveedor = new CtaCteProveedor();

        $ctaCteProveedor->proveedor_id = $comprobante->proveedor_id;
        $ctaCteProveedor->fecha = $comprobante->fecha;
        $ctaCteProveedor->comprobante_compras_id = $comprobante->id;
        $ctaCteProveedor->tipo_comp_compras_id = $comprobante->tipo_comp_compras_id;
        $ctaCteProveedor->descripcion = $comprobante->tipo_comp_compras->codigo . '-';

        return $ctaCteProveedor;
    }
}