<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vendedor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('vendedores', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('zona_id')->unsigned();
            $table->string('nombre');
            $table->decimal('comision', 7, 2);
			$table->timestamps();
			
            //relacion con zonas            
            $table->foreign('zona_id')
                ->references('id')->on('zonas');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendedores');
    }
}
