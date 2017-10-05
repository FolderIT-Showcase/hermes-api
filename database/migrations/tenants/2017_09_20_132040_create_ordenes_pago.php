<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenesPago extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes_pago', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proveedor_id')->unsigned();
//            $table->decimal('punto_venta', 4, 0);
//            $table->decimal('numero', 8, 0);
            $table->date('fecha');
            $table->decimal('importe', 15, 2);
            $table->timestamps();

            //relación con proveedor
            $table->foreign('proveedor_id')
                ->references('id')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordenes_pago');
    }
}
