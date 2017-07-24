<?php

use Illuminate\Database\Seeder;

class ParametrosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parametros')->delete();

        $parametros = [];
        $parametros[] = [
            'modulo' => 'GENERAL',
            'nombre' => 'EMPRESA_NOMBRE',
            'descripcion' => 'Nombre de la Empresa',
            'valor' => 'EJEMPLO S.A.',
            'data_type' => 'STR'
        ];
        $parametros[] = [
            'modulo' => 'GENERAL',
            'nombre' => 'EMPRESA_CUIT',
            'descripcion' => 'CUIT de la Empresa',
            'valor' => '30-11111111-5',
            'data_type' => 'STR'
        ];
        $parametros[] = [
            'modulo' => 'GENERAL',
            'nombre' => 'EMPRESA_TIPO_RESP',
            'descripcion' => 'Tipo de Responsable ante el IVA de la Empresa',
            'valor' => 'RI',
            'data_type' => 'STR'
        ];
        $parametros[] = [
            'modulo' => 'GENERAL',
            'nombre' => 'EMPRESA_DOMICILIO',
            'descripcion' => 'Domicilio de la Empresa',
            'valor' => 'Gral. San Martin 1523 - Santa Fe - Argentina',
            'data_type' => 'STR'
        ];
        $parametros[] = [
            'modulo' => 'GENERAL',
            'nombre' => 'EMPRESA_TELEFONO',
            'descripcion' => 'Telefono de la Empresa',
            'valor' => '(0342) 455066',
            'data_type' => 'STR'
        ];
        $parametros[] = [
            'modulo' => 'VENTAS',
            'nombre' => 'VTA_MODIFICA_PRECIO',
            'descripcion' => 'Permite modificar el precio unitario en la Factura',
            'valor' => 'N',
            'data_type' => 'BOOL'
        ];
        $parametros[] = [
            'modulo' => 'VENTAS',
            'nombre' => 'VTA_USA_DESCUENTO',
            'descripcion' => 'Habilita los campos de Descuento en la Factura',
            'valor' => 'S',
            'data_type' => 'BOOL'
        ];
        $parametros[] = [
            'modulo' => 'VENTAS',
            'nombre' => 'VTA_DESCUENTO_MAX',
            'descripcion' => 'Máximo descuento permitido al Facturar',
            'valor' => '25',
            'data_type' => 'NUM'
        ];

        DB::table('parametros')->insert($parametros);
        
    }
}
