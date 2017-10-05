<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPuntoVentaFkToParametrosUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parametros_usuario', function (Blueprint $table) {
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
        Schema::table('parametros_usuario', function (Blueprint $table) {
            $table->dropForeign('parametros_usuario_punto_venta_foreign');
        });
    }
}
