<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('tipo_comprobantes', function (Blueprint $table) {
            $table->increments('id');
			$table->string('codigo', 3)->nullable();
			$table->string('nombre');
			$table->timestamps();
        });
		
		Schema::create('contadores', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('tipo_comprobante_id')->unsigned();			
			$table->decimal('punto_venta', 4, 0);
			$table->decimal('ultimo_generado', 8, 0);
			$table->timestamps();
			
            //relacion con tipo_comprobantes
            $table->foreign('tipo_comprobante_id')
                ->references('id')->on('tipo_comprobantes'); 	
        });
		
		Schema::create('comprobantes', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('cliente_id')->unsigned();
			$table->integer('tipo_comprobante_id')->unsigned();
			$table->date('fecha');
			$table->decimal('punto_venta', 4, 0);
			$table->decimal('numero', 8, 0);
			$table->string('cliente_nombre');
			$table->string('cliente_tipo_resp',3);
			$table->string('cliente_cuit')->nullable();			
			$table->decimal('importe_neto', 15, 2);
			$table->decimal('alicuota_iva', 7, 2);
			$table->decimal('importe_iva', 15, 2);
			$table->decimal('importe_total', 15, 2);
			$table->decimal('saldo', 15, 2);
			$table->string('cae')->nullable();
			$table->date('fecha_cae')->nullable();
			$table->date('fecha_venc_cae')->nullable();
			$table->boolean('anulado')->default(false);			
			$table->timestamps();   

            //relacion con clientes            
            $table->foreign('cliente_id')
                ->references('id')->on('clientes');
				
            //relacion con tipo_comprobantes
            $table->foreign('tipo_comprobante_id')
                ->references('id')->on('tipo_comprobantes'); 			
        });
		
		Schema::create('compro_items', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('comprobante_id')->unsigned();
			$table->integer('articulo_id')->unsigned();
			$table->integer('cantidad')->default(1);
			$table->decimal('importe_unitario', 15, 2);
			$table->decimal('costo_unitario', 15, 2);
			$table->decimal('importe_total', 15, 2);
			$table->decimal('importe_neto', 15, 2);
			$table->decimal('alicuota_iva', 7, 2);
			$table->decimal('importe_iva', 15, 2);			
			$table->timestamps();   

            //relacion con comprobantes            
            $table->foreign('comprobante_id')
                ->references('id')->on('comprobantes');
				
            //relacion con articulos
            $table->foreign('articulo_id')
                ->references('id')->on('articulos'); 			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('compro_items');
		Schema::dropIfExists('comprobantes');		
        Schema::dropIfExists('tipo_comprobantes');
		Schema::dropIfExists('contadores');
    }
}
