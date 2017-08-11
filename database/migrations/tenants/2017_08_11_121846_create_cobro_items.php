<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCobroItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobro_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cobro_id')->unsigned();
            $table->integer('comprobante_id')->unsigned()->nullable();
            $table->string('descripcion', 200)->nullable();
            $table->decimal('importe', 15, 2);
            $table->decimal('descuento', 15, 2);
            $table->decimal('importe_total', 15, 2);
            $table->boolean('anticipo')->default(false);
            $table->timestamps();

            //relación con cobros
            $table->foreign('cobro_id')
                ->references('id')->on('cobros');

            //relación con comprobantes
            $table->foreign('comprobante_id')
                ->references('id')->on('comprobantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cobro_items');
    }
}
