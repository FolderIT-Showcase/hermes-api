<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListaPreciosTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_precios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->decimal('porcentaje', 15, 2)->default(0);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('lista_precio_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lista_id')->unsigned();
            $table->integer('articulo_id')->unsigned();
            $table->decimal('precio_costo', 15, 2);
            $table->decimal('precio_venta', 15, 2);
            $table->timestamps();

            //relacion con lista de precios
            $table->foreign('lista_id')
                ->references('id')->on('lista_precios');

            //relacion con articulos
            $table->foreign('articulo_id')
                ->references('id')->on('articulos');
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->integer('lista_id')->unsigned()->nullable()->after('tipo_categoria_id');

            //relacion con lista de precios
            $table->foreign('lista_id')
                ->references('id')->on('lista_precios');
        });

        Schema::table('comprobantes', function (Blueprint $table) {
            $table->integer('lista_id')->unsigned()->nullable()->after('tipo_comprobante_id');

            //relacion con lista de precios
            $table->foreign('lista_id')
                ->references('id')->on('lista_precios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign('clientes_lista_id_foreign');
            $table->dropColumn('lista_id');
        });

        Schema::table('comprobantes', function (Blueprint $table) {
            $table->dropForeign('comprobantes_lista_id_foreign');
            $table->dropColumn('lista_id');
        });

        Schema::dropIfExists('lista_precio_items');
        Schema::dropIfExists('lista_precios');

    }
}
