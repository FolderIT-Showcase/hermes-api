<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenPagoValores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_pago_valores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orden_pago_id')->unsigned();
            $table->integer('medios_pago_id')->unsigned();
            $table->decimal('importe', 15, 2);
            $table->timestamps();

            //relación con orden pago
            $table->foreign('orden_pago_id')
                ->references('id')->on('ordenes_pago');

            //relación con medios_pago
            $table->foreign('medios_pago_id')
                ->references('id')->on('medios_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_pago_valores');
    }
}
