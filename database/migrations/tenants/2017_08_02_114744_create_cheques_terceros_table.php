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
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->integer('banco_id')->unsigned();
            $table->string('sucursal', 50)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('nro_interno', 10)->nullable();
            $table->decimal('importe', 15, 2);
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_ingreso');
            $table->date('fecha_vencimiento')->nullable();
            $table->date('fecha_cobro')->nullable();
            $table->string('origen', 100)->nullable();
            $table->string('destinatario', 100)->nullable();
            $table->string('estado', 1);
            $table->string('descripcion', 500)->nullable();
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
