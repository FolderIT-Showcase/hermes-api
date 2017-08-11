<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtacteproveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('cta_cte_proveedores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proveedor_id')->unsigned();
            $table->integer('tipo_comp_compras_id')->unsigned();
            $table->integer('comprobante_compras_id')->unsigned()->nullable();
            $table->date('fecha');
            $table->string('descripcion');
            $table->decimal('debe', 15, 2);
            $table->decimal('haber', 15, 2);
            $table->timestamps();

            //relacion con proveedores
            $table->foreign('proveedor_id')
                ->references('id')->on('proveedores');

            //relacion con tipo_comprobantes
            $table->foreign('tipo_comp_compras_id')
                ->references('id')->on('tipo_comprobantes_compras');

            //relacion con comprobantes
            $table->foreign('comprobante_compras_id')
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
        Schema::dropIfExists('cta_cte_proveedores');
    }
}