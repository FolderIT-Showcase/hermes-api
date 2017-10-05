<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PuntosVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puntos_venta', function (Blueprint $table) {
            $table->decimal('id', 4, 0);
            $table->boolean('habilitado');
            $table->string('descripcion')->nullable();
            $table->string('tipo_impresion',3);	// IF, IMP, FE
            $table->timestamps();

            $table->primary('id');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puntos_venta');
    }
}
