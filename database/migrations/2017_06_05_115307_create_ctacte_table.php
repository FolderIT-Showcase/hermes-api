<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtacteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
		Schema::create('cta_cte_clientes', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->integer('tipo_comprobante_id')->unsigned();
			$table->integer('comprobante_id')->unsigned()->nullable();
			$table->date('fecha');
			$table->string('descripcion');
			$table->decimal('debe', 15, 2);
			$table->decimal('haber', 15, 2);
			$table->timestamps();   

            //relacion con clientes            
            $table->foreign('cliente_id')
                ->references('id')->on('clientes');
				
            //relacion con tipo_comprobantes
            $table->foreign('tipo_comprobante_id')
                ->references('id')->on('tipo_comprobantes'); 			
				
            //relacion con tipo_comprobantes
            $table->foreign('comprobante_id')
                ->references('id')->on('comprobantes'); 		
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cta_cte_clientes');
    }
}
