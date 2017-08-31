<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCobroIdToCtaCteCliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cta_cte_clientes', function(Blueprint $table) {
            $table->integer('cobro_id')->unsigned()->nullable();

            //relación con cobro
            $table->foreign('cobro_id')
                ->references('id')->on('cobros');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cta_cte_clientes', function(Blueprint $table) {
            $table->dropForeign('cta_cte_clientes_cobro_id_foreign');
            $table->dropColumn('cobro_id');
        });
    }
}
