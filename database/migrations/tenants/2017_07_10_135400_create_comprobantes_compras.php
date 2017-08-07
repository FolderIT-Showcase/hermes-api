<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprobantesCompras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('tipo_comprobantes_compras', function (Blueprint $table) {
            $table->increments('id');
			$table->string('codigo', 3)->nullable();
			$table->string('nombre');
			$table->timestamps();
        });
		
		Schema::create('tipo_retenciones', function (Blueprint $table) {
            $table->increments('id');
			$table->string('nombre');
			$table->decimal('alicuota', 7, 2);
			$table->timestamps();
        });
		
		Schema::create('comprobantes_compras', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('proveedor_id')->unsigned();
			$table->integer('tipo_comp_compras_id')->unsigned();
			$table->integer('periodo_id')->unsigned();
			$table->date('fecha');
			$table->decimal('punto_venta', 4, 0);
			$table->decimal('numero', 8, 0);
			$table->string('proveedor_nombre');
			$table->string('proveedor_tipo_resp',3);
			$table->string('proveedor_cuit');			
			$table->decimal('importe_total', 15, 2);			
			$table->decimal('saldo', 15, 2);
			$table->boolean('anulado')->default(false);			
			$table->timestamps();   

            //relacion con proveedores            
            $table->foreign('proveedor_id')
                ->references('id')->on('proveedores');
			
            //relacion con tipo_comprobantes compras
            $table->foreign('tipo_comp_compras_id')
                ->references('id')->on('tipo_comprobantes_compras');

            //relacion con periodos fiscales
            $table->foreign('periodo_id')
                ->references('id')->on('periodos_fiscales');
				
        });
		
		Schema::create('comprobantes_compras_importes', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('comprobante_id')->unsigned();
			$table->decimal('importe_neto_gravado', 15, 2);
			$table->decimal('importe_neto_no_gravado', 15, 2);
			$table->decimal('alicuota_iva', 7, 2);
			$table->decimal('importe_iva', 15, 2);
			$table->timestamps();   

            //relacion con comprobantes compras            
            $table->foreign('comprobante_id')
                ->references('id')->on('comprobantes_compras');			
        });
		
		Schema::create('comprobantes_compras_retenciones', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('comprobante_id')->unsigned();		
			$table->integer('retencion_id')->unsigned();
			$table->decimal('base_imponible', 15, 2);
			$table->decimal('alicuota', 7, 2);
			$table->decimal('importe', 15, 2);		
			$table->timestamps();

            //relacion con comprobantes compras            
            $table->foreign('comprobante_id')
                ->references('id')->on('comprobantes_compras');
				
            //relacion con retenciones            
            $table->foreign('retencion_id')
                ->references('id')->on('tipo_retenciones');			
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('comprobantes_compras_retenciones');
		Schema::dropIfExists('comprobantes_compras_importes');
		Schema::dropIfExists('comprobantes_compras');
		Schema::dropIfExists('tipo_retenciones');
		Schema::dropIfExists('tipo_comprobantes_compras');
    }
}
