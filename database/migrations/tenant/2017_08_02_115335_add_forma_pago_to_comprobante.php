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

            //relación con cliente
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
            $table->dropForeign('forma_pago_id');
            $table->dropColumn('forma_pago_id');
        });
    }
}
