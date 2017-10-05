<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrdenPagoIdToCtaCteProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cta_cte_proveedores', function(Blueprint $table) {
            $table->integer('orden_pago_id')->unsigned()->nullable();

            //relación con cobro
            $table->foreign('orden_pago_id')
                ->references('id')->on('ordenes_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cta_cte_proveedores', function(Blueprint $table) {
            $table->dropForeign('cta_cte_proveedores_orden_pago_id_foreign');
            $table->dropColumn('orden_pago_id');
        });
    }
}
