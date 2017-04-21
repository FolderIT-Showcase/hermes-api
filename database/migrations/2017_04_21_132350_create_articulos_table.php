<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->increments('id');
			$table->string('codigo', 20)->nullable();
			$table->string('nombre');
			$table->timestamps();
        });
		
		Schema::create('rubros', function (Blueprint $table) {
            $table->increments('id');
			$table->string('codigo', 20)->nullable();
			$table->string('nombre');
			$table->timestamps();
        });
		
		Schema::create('subrubros', function (Blueprint $table) {
            $table->increments('id');
			$table->string('codigo', 20)->nullable();
			$table->string('nombre');
			$table->timestamps();
        });
		
		Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('marca_id')->unsigned();
			$table->integer('subrubro_id')->unsigned();
			$table->string('codigo', 10)->nullable();
			$table->string('codigo_fabrica', 30)->nullable();
			$table->string('codigo_auxiliar', 30)->nullable();
			$table->string('nombre');
			$table->string('nombre_reducido', 20)->nullable();
			$table->boolean('lleva_stock');
			$table->decimal('costo', 15, 2)->nullable();
			$table->integer('punto_pedido')->nullable();
			$table->integer('bajo_minimo')->nullable();			
			$table->boolean('activo')->default(true);
			$table->string('motivo')->nullable();
			$table->timestamps();   

            //relacion con marcas            
            $table->foreign('marca_id')
                ->references('id')->on('marcas');
				
            //relacion con subrubros
            $table->foreign('subrubro_id')
                ->references('id')->on('subrubros'); 			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('articulos');
        Schema::dropIfExists('marcas');
		Schema::dropIfExists('subrubros');
		Schema::dropIfExists('rubros');
    }
}
