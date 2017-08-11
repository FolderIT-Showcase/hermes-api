<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChequesTercerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheques_terceros', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('banco_id')->unsigned();
            $table->string('sucursal', 50);
            $table->string('numero', 20);
            $table->string('nro_interno', 10);
            $table->decimal('importe', 15, 2);
            $table->date('fecha_emision');
            $table->date('fecha_ingreso');
            $table->date('fecha_vencimiento');
            $table->date('fecha_cobro');
            $table->string('origen', 100);
            $table->string('destinatario', 100);
            $table->string('estado', 1);
            $table->string('descripcion', 500);
            $table->timestamps();

            //relación con cliente
            $table->foreign('cliente_id')
                ->references('id')->on('clientes');

            //relación con banco
            $table->foreign('banco_id')
                ->references('id')->on('bancos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheques_terceros');
    }
}
