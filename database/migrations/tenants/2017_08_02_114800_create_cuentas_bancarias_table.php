<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentasBancariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas_bancarias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('banco_id')->unsigned();
            $table->string('tipo', 20);
            $table->string('numero', 50);
            $table->timestamps();

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
        Schema::dropIfExists('cuentas_bancarias');
    }
}
