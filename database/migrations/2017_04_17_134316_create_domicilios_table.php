<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDomiciliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domicilios', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->integer('localidad_id')->unsigned();
			$table->string('tipo', 2);		// Particular, Laboral, Fiscal
			$table->string('direccion');			
			$table->timestamps();
			
            //relacion con localidad            
            $table->foreign('localidad_id')
                ->references('id')->on('localidades');
				
            //relacion con localidad            
            $table->foreign('cliente_id')
                ->references('id')->on('clientes')
                ->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domicilios');
    }
}
