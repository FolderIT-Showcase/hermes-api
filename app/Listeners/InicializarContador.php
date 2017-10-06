<?php

namespace App\Listeners;

use App\Contador;
use App\Events\PuntoVentaCreated;
use App\TipoComprobante;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class InicializarContador
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PuntoVentaCreated  $event
     * @return void
     */
    public function handle(PuntoVentaCreated $event)
    {
        $puntoVenta = $event->puntoVenta;

        $contadores = [];
        $tiposComprobantes = TipoComprobante::all();
        foreach ($tiposComprobantes as $tipoComprobante) {
            $contadores[] = ['tipo_comprobante_id' => $tipoComprobante->id,
                            'punto_venta' => $puntoVenta->id,
                            'ultimo_generado' => 0];
        }

        Contador::insert($contadores);
    }
}
