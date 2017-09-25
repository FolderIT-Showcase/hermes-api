<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChequesPropiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cheques_propios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cuenta_bancaria_id')->unsigned();
            $table->string('numero', 20)->nullable();
            $table->decimal('importe', 15, 2);
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->string('destinatario', 100)->nullable();
            $table->string('descripcion', 500)->nullable();
            $table->integer('orden_pago_valor_id')->unsigned()->nullable();
            $table->timestamps();

            //relación con cuenta bancaria
            $table->foreign('cuenta_bancaria_id')
                ->references('id')->on('cuentas_bancarias');

            //relación con orden pago
            $table->foreign('orden_pago_valor_id')
                ->references('id')->on('orden_pago_valores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cheques_propios');
    }
}
