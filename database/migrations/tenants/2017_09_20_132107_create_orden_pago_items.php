<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenPagoItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_pago_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orden_pago_id')->unsigned();
            $table->integer('comprobante_compra_id')->unsigned()->nullable();
            $table->string('descripcion', 200)->nullable();
            $table->decimal('importe', 15, 2);
            $table->decimal('descuento', 15, 2);
            $table->decimal('importe_total', 15, 2);
            $table->boolean('anticipo')->default(false);
            $table->timestamps();

            //relación con orden pago
            $table->foreign('orden_pago_id')
                ->references('id')->on('ordenes_pago');

            //relación con comprobantes compra
            $table->foreign('comprobante_compra_id')
                ->references('id')->on('comprobantes_compras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_pago_items');
    }
}
