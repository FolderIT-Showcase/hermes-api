<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPuntoVentaFkToComprobante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobantes', function (Blueprint $table) {
            //relación con puntos_venta
            $table->foreign('punto_venta')
                ->references('id')->on('puntos_venta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobantes', function(Blueprint $table) {
            $table->dropForeign('comprobantes_punto_venta_foreign');
        });
    }
}
