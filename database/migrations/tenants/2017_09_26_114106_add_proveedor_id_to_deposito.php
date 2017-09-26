<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProveedorIdToDeposito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('depositos', function(Blueprint $table) {
            $table->integer('orden_pago_valor_id')->unsigned()->nullable();
            $table->integer('proveedor_id')->unsigned()->nullable();

            //relación con orden pago valor
            $table->foreign('orden_pago_valor_id')
                ->references('id')->on('orden_pago_valores');

            //relación con proveedor
            $table->foreign('proveedor_id')
                ->references('id')->on('proveedores');

            DB::statement("ALTER TABLE depositos MODIFY COLUMN cuenta_id int(10) UNSIGNED NULL");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depositos', function(Blueprint $table) {
            $table->dropForeign('depositos_orden_pago_valor_id_foreign');
            $table->dropColumn('orden_pago_valor_id');

            $table->dropForeign('depositos_proveedor_id_foreign');
            $table->dropColumn('proveedor_id');

            DB::statement("ALTER TABLE depositos MODIFY COLUMN cuenta_id int(10) UNSIGNED NOT NULL");
        });
    }
}
