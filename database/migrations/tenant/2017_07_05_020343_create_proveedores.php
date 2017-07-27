<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id');
			$table->string('codigo',10);
            $table->string('nombre');
            $table->string('tipo_responsable',3);	// RI, MON, CF
            $table->string('cuit')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->nullable();
            $table->boolean('activo');   
			$table->string('motivo')->nullable();	// Motivo para inactivo		
			$table->timestamps();	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
