<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTarjetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarjetas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->integer('tarjeta_id')->unsigned();
            $table->decimal('importe', 15, 2);
            $table->date('fecha_ingreso');
            $table->date('fecha_acreditacion')->nullable();
            $table->string('estado', 1);
            $table->string('descripcion', 500)->nullable();
            $table->timestamps();

            //relación con cliente
            $table->foreign('cliente_id')
                ->references('id')->on('clientes');

            //relación con banco
            $table->foreign('tarjeta_id')
                ->references('id')->on('tipo_tarjetas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarjetas');
    }
}
