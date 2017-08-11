<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCobroValores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobro_valores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cobro_id')->unsigned();
            $table->integer('medio_pago_id')->unsigned();
            $table->decimal('importe', 15, 2);
            $table->timestamps();

            //relación con cobros
            $table->foreign('cobro_id')
                ->references('id')->on('cobros');

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
        Schema::dropIfExists('cobro_items');
    }
}
