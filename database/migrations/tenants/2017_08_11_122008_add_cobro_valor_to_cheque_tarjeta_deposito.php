<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCobroValorToChequeTarjetaDeposito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cheques_terceros', function(Blueprint $table) {
            $table->integer('cobro_valor_id')->unsigned()->nullable();

            //relación con cobro_valores
            $table->foreign('cobro_valor_id')
                ->references('id')->on('cobro_valores');
        });

        Schema::table('tarjetas', function(Blueprint $table) {
            $table->integer('cobro_valor_id')->unsigned()->nullable();

            //relación con cobro_valores
            $table->foreign('cobro_valor_id')
                ->references('id')->on('cobro_valores');
        });

        Schema::table('depositos', function(Blueprint $table) {
            $table->integer('cobro_valor_id')->unsigned()->nullable();

            //relación con cobro_valores
            $table->foreign('cobro_valor_id')
                ->references('id')->on('cobro_valores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cheques_terceros', function(Blueprint $table) {
            $table->dropForeign('cheques_terceros_cobro_valor_id_foreign');
            $table->dropColumn('cobro_valor_id');
        });

        Schema::table('tarjetas', function(Blueprint $table) {
            $table->dropForeign('tarjetas_cobro_valor_id_foreign');
            $table->dropColumn('cobro_valor_id');
        });

        Schema::table('depositos', function(Blueprint $table) {
            $table->dropForeign('depositos_cobro_valor_id_foreign');
            $table->dropColumn('cobro_valor_id');
        });
    }
}
