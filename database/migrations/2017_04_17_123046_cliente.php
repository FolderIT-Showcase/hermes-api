<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cliente extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('vendedor_id')->unsigned()->nullable();
			$table->integer('zona_id')->unsigned()->nullable();
			$table->integer('tipo_categoria_id')->unsigned()->nullable();
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
			
            //relacion con vendedor            
            $table->foreign('vendedor_id')
                ->references('id')->on('vendedores');
				
            //relacion con zonas            
            $table->foreign('zona_id')
                ->references('id')->on('zonas');
				
            //relacion con tipo_categoria            
            $table->foreign('tipo_categoria_id')
                ->references('id')->on('tipo_categoria_cliente');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
