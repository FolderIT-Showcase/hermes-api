<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormaPagoToComprobante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobantes', function(Blueprint $table) {
            $table->integer('forma_pago_id')->unsigned()->nullable();

            //relación con forma_pago
            $table->foreign('forma_pago_id')
                ->references('id')->on('tipo_forma_pagos');
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
            $table->dropForeign('comprobantes_forma_pago_id_foreign');
            $table->dropColumn('forma_pago_id');
        });
    }
}
