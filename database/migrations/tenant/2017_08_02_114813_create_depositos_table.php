<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliente_id')->unsigned();
            $table->integer('cuenta_id')->unsigned();
            $table->string('numero', 20);
            $table->decimal('importe', 15, 2);
            $table->date('fecha');
            $table->date('fecha_acreditacion');
            $table->string('tipo', 1);
            $table->string('descripcion', 500);
            $table->timestamps();

            //relación con cliente
            $table->foreign('cliente_id')
                ->references('id')->on('clientes');

            //relación con cuenta bancaria
            $table->foreign('cuenta_id')
                ->references('id')->on('cuentas_bancarias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depositos');
    }
}
