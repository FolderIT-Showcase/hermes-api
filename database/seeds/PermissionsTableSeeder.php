<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permisos Cliente
        $createCliente = Permission::firstOrNew(array('name' => 'create_cliente'));
        $createCliente->name         = 'create_cliente';
        $createCliente->display_name = 'Crear Clientes';
        $createCliente->description  = 'Crear nuevos clientes';
        $createCliente->save();

        $editCliente = permission::firstOrNew(array('name' => 'edit_cliente'));
        $editCliente->name         = 'edit_cliente';
        $editCliente->display_name = 'Editar Clientes';
        $editCliente->description  = 'Editar clientes existentes';
        $editCliente->save();

        $viewCliente = permission::firstOrNew(array('name' => 'view_cliente'));
        $viewCliente->name         = 'view_cliente';
        $viewCliente->display_name = 'Ver Clientes';
        $viewCliente->description  = 'Ver clientes existentes';
        $viewCliente->save();

        $deleteCliente = permission::firstOrNew(array('name' => 'delete_cliente'));
        $deleteCliente->name         = 'delete_cliente';
        $deleteCliente->display_name = 'Borrar Clientes';
        $deleteCliente->description  = 'Borrar clientes existentes';
        $deleteCliente->save();
        
        //Permisos artículos
        $createArticulo = permission::firstOrNew(array('name' => 'create_articulo'));
        $createArticulo->name         = 'create_articulo';
        $createArticulo->display_name = 'Crear Articulos';
        $createArticulo->description  = 'Crear nuevos articulos';
        $createArticulo->save();

        $editArticulo = permission::firstOrNew(array('name' => 'edit_articulo'));
        $editArticulo->name         = 'edit_articulo';
        $editArticulo->display_name = 'Editar Articulos';
        $editArticulo->description  = 'Editar articulos existentes';
        $editArticulo->save();

        $viewArticulo = permission::firstOrNew(array('name' => 'view_articulo'));
        $viewArticulo->name         = 'view_articulo';
        $viewArticulo->display_name = 'Ver Articulos';
        $viewArticulo->description  = 'Ver articulos existentes';
        $viewArticulo->save();

        $deleteArticulo = permission::firstOrNew(array('name' => 'delete_articulo'));
        $deleteArticulo->name         = 'delete_articulo';
        $deleteArticulo->display_name = 'Borrar Articulos';
        $deleteArticulo->description  = 'Borrar articulos existentes';
        $deleteArticulo->save();

        //Permisos vendedores
        $createVendedor = permission::firstOrNew(array('name' => 'create_vendedor'));
        $createVendedor->name         = 'create_vendedor';
        $createVendedor->display_name = 'Crear Vendedors';
        $createVendedor->description  = 'Crear nuevos vendedors';
        $createVendedor->save();

        $editVendedor = permission::firstOrNew(array('name' => 'edit_vendedor'));
        $editVendedor->name         = 'edit_vendedor';
        $editVendedor->display_name = 'Editar Vendedors';
        $editVendedor->description  = 'Editar vendedors existentes';
        $editVendedor->save();

        $viewVendedor = permission::firstOrNew(array('name' => 'view_vendedor'));
        $viewVendedor->name         = 'view_vendedor';
        $viewVendedor->display_name = 'Ver Vendedors';
        $viewVendedor->description  = 'Ver vendedors existentes';
        $viewVendedor->save();

        $deleteVendedor = permission::firstOrNew(array('name' => 'delete_vendedor'));
        $deleteVendedor->name         = 'delete_vendedor';
        $deleteVendedor->display_name = 'Borrar Vendedors';
        $deleteVendedor->description  = 'Borrar vendedors existentes';
        $deleteVendedor->save();

        //Permisos lista de precios
        $createListaPrecios = permission::firstOrNew(array('name' => 'create_lista_precios'));
        $createListaPrecios->name         = 'create_lista_precios';
        $createListaPrecios->display_name = 'Crear ListaPrecios';
        $createListaPrecios->description  = 'Crear nuevas listas de precios';
        $createListaPrecios->save();

        $editListaPrecios = permission::firstOrNew(array('name' => 'edit_lista_precios'));
        $editListaPrecios->name         = 'edit_lista_precios';
        $editListaPrecios->display_name = 'Editar ListaPrecios';
        $editListaPrecios->description  = 'Editar listas de precios existentes';
        $editListaPrecios->save();

        $viewListaPrecios = permission::firstOrNew(array('name' => 'view_lista_precios'));
        $viewListaPrecios->name         = 'view_lista_precios';
        $viewListaPrecios->display_name = 'Ver ListaPrecioss';
        $viewListaPrecios->description  = 'Ver listas de precios existentes';
        $viewListaPrecios->save();

        $deleteListaPrecios = permission::firstOrNew(array('name' => 'delete_lista_precios'));
        $deleteListaPrecios->name         = 'delete_lista_precios';
        $deleteListaPrecios->display_name = 'Borrar ListaPrecios';
        $deleteListaPrecios->description  = 'Borrar listas de precios existentes';
        $deleteListaPrecios->save();
        
        //Permisos cuenta corriente lista_precios
        $viewCtaCte = permission::firstOrNew(array('name' => 'view_cta_cte'));
        $viewCtaCte->name         = 'view_cta_cte';
        $viewCtaCte->display_name = 'Ver Cuentas Corrientes';
        $viewCtaCte->description  = 'Ver Cuentas Corrientes de lista_precioss existentes';
        $viewCtaCte->save();

        //Permisos Facturas
        $createFactura = permission::firstOrNew(array('name' => 'create_factura'));
        $createFactura->name         = 'create_factura';
        $createFactura->display_name = 'Crear Facturas';
        $createFactura->description  = 'Crear nuevas facturas';
        $createFactura->save();

        $editFactura = permission::firstOrNew(array('name' => 'edit_factura'));
        $editFactura->name         = 'edit_factura';
        $editFactura->display_name = 'Editar Facturas';
        $editFactura->description  = 'Editar facturas existentes';
        $editFactura->save();

        $viewFactura = permission::firstOrNew(array('name' => 'view_factura'));
        $viewFactura->name         = 'view_factura';
        $viewFactura->display_name = 'Ver Facturas';
        $viewFactura->description  = 'Ver facturas existentes';
        $viewFactura->save();

        $deleteFactura = permission::firstOrNew(array('name' => 'delete_factura'));
        $deleteFactura->name         = 'delete_factura';
        $deleteFactura->display_name = 'Borrar Facturas';
        $deleteFactura->description  = 'Borrar facturas existentes';
        $deleteFactura->save();

        //Permisos Presupuesto
        $createPresupuesto = permission::firstOrNew(array('name' => 'create_presupuesto'));
        $createPresupuesto->name         = 'create_presupuesto';
        $createPresupuesto->display_name = 'Crear Presupuestos';
        $createPresupuesto->description  = 'Crear nuevos presupuestos';
        $createPresupuesto->save();

        $editPresupuesto = permission::firstOrNew(array('name' => 'edit_presupuesto'));
        $editPresupuesto->name         = 'edit_presupuesto';
        $editPresupuesto->display_name = 'Editar Presupuestos';
        $editPresupuesto->description  = 'Editar presupuestos existentes';
        $editPresupuesto->save();

        $viewPresupuesto = permission::firstOrNew(array('name' => 'view_presupuesto'));
        $viewPresupuesto->name         = 'view_presupuesto';
        $viewPresupuesto->display_name = 'Ver Presupuestos';
        $viewPresupuesto->description  = 'Ver presupuestos existentes';
        $viewPresupuesto->save();

        $deletePresupuesto = permission::firstOrNew(array('name' => 'delete_presupuesto'));
        $deletePresupuesto->name         = 'delete_presupuesto';
        $deletePresupuesto->display_name = 'Borrar Presupuestos';
        $deletePresupuesto->description  = 'Borrar presupuestos existentes';
        $deletePresupuesto->save();

        //Permisos Nota Debito
        $createNotaDebito = permission::firstOrNew(array('name' => 'create_nota_debito'));
        $createNotaDebito->name         = 'create_nota_debito';
        $createNotaDebito->display_name = 'Crear Notas de Debito';
        $createNotaDebito->description  = 'Crear nuevas Notas de Debito';
        $createNotaDebito->save();

        $editNotaDebito = permission::firstOrNew(array('name' => 'edit_nota_debito'));
        $editNotaDebito->name         = 'edit_nota_debito';
        $editNotaDebito->display_name = 'Editar Notas de Debito';
        $editNotaDebito->description  = 'Editar notas de Debito existentes';
        $editNotaDebito->save();

        $viewNotaDebito = permission::firstOrNew(array('name' => 'view_nota_debito'));
        $viewNotaDebito->name         = 'view_nota_debito';
        $viewNotaDebito->display_name = 'Ver Notas de Debito';
        $viewNotaDebito->description  = 'Ver notas de Debito existentes';
        $viewNotaDebito->save();

        $deleteNotaDebito = permission::firstOrNew(array('name' => 'delete_nota_debito'));
        $deleteNotaDebito->name         = 'delete_nota_debito';
        $deleteNotaDebito->display_name = 'Borrar Notas de Debito';
        $deleteNotaDebito->description  = 'Borrar notas de Debito existentes';
        $deleteNotaDebito->save();

        //Permisos Nota Credito
        $createNotaCredito = permission::firstOrNew(array('name' => 'create_nota_credito'));
        $createNotaCredito->name         = 'create_nota_credito';
        $createNotaCredito->display_name = 'Crear Notas de Credito';
        $createNotaCredito->description  = 'Crear nuevas Notas de Credito';
        $createNotaCredito->save();

        $editNotaCredito = permission::firstOrNew(array('name' => 'edit_nota_credito'));
        $editNotaCredito->name         = 'edit_nota_credito';
        $editNotaCredito->display_name = 'Editar Notas de Credito';
        $editNotaCredito->description  = 'Editar notas de Credito existentes';
        $editNotaCredito->save();

        $viewNotaCredito = permission::firstOrNew(array('name' => 'view_nota_credito'));
        $viewNotaCredito->name         = 'view_nota_credito';
        $viewNotaCredito->display_name = 'Ver Notas de Credito';
        $viewNotaCredito->description  = 'Ver notas de Credito existentes';
        $viewNotaCredito->save();

        $deleteNotaCredito = permission::firstOrNew(array('name' => 'delete_nota_credito'));
        $deleteNotaCredito->name         = 'delete_nota_credito';
        $deleteNotaCredito->display_name = 'Borrar Notas de Credito';
        $deleteNotaCredito->description  = 'Borrar notas de Credito existentes';
        $deleteNotaCredito->save();

        //Permisos Marca
        $createMarca = permission::firstOrNew(array('name' => 'create_marca'));
        $createMarca->name         = 'create_marca';
        $createMarca->display_name = 'Crear Marcas';
        $createMarca->description  = 'Crear nuevos marcas';
        $createMarca->save();

        $editMarca = permission::firstOrNew(array('name' => 'edit_marca'));
        $editMarca->name         = 'edit_marca';
        $editMarca->display_name = 'Editar Marcas';
        $editMarca->description  = 'Editar marcas existentes';
        $editMarca->save();

        $viewMarca = permission::firstOrNew(array('name' => 'view_marca'));
        $viewMarca->name         = 'view_marca';
        $viewMarca->display_name = 'Ver Marcas';
        $viewMarca->description  = 'Ver marcas existentes';
        $viewMarca->save();

        $deleteMarca = permission::firstOrNew(array('name' => 'delete_marca'));
        $deleteMarca->name         = 'delete_marca';
        $deleteMarca->display_name = 'Borrar Marcas';
        $deleteMarca->description  = 'Borrar marcas existentes';
        $deleteMarca->save();

        //Permisos Rubro
        $createRubro = permission::firstOrNew(array('name' => 'create_rubro'));
        $createRubro->name         = 'create_rubro';
        $createRubro->display_name = 'Crear Rubros';
        $createRubro->description  = 'Crear nuevos rubros';
        $createRubro->save();

        $editRubro = permission::firstOrNew(array('name' => 'edit_rubro'));
        $editRubro->name         = 'edit_rubro';
        $editRubro->display_name = 'Editar Rubros';
        $editRubro->description  = 'Editar rubros existentes';
        $editRubro->save();

        $viewRubro = permission::firstOrNew(array('name' => 'view_rubro'));
        $viewRubro->name         = 'view_rubro';
        $viewRubro->display_name = 'Ver Rubros';
        $viewRubro->description  = 'Ver rubros existentes';
        $viewRubro->save();

        $deleteRubro = permission::firstOrNew(array('name' => 'delete_rubro'));
        $deleteRubro->name         = 'delete_rubro';
        $deleteRubro->display_name = 'Borrar Rubros';
        $deleteRubro->description  = 'Borrar rubros existentes';
        $deleteRubro->save();

        //Permisos Subrubro
        $createSubrubro = permission::firstOrNew(array('name' => 'create_subrubro'));
        $createSubrubro->name         = 'create_subrubro';
        $createSubrubro->display_name = 'Crear Subrubros';
        $createSubrubro->description  = 'Crear nuevos subrubros';
        $createSubrubro->save();

        $editSubrubro = permission::firstOrNew(array('name' => 'edit_subrubro'));
        $editSubrubro->name         = 'edit_subrubro';
        $editSubrubro->display_name = 'Editar Subrubros';
        $editSubrubro->description  = 'Editar subrubros existentes';
        $editSubrubro->save();

        $viewSubrubro = permission::firstOrNew(array('name' => 'view_subrubro'));
        $viewSubrubro->name         = 'view_subrubro';
        $viewSubrubro->display_name = 'Ver Subrubros';
        $viewSubrubro->description  = 'Ver subrubros existentes';
        $viewSubrubro->save();

        $deleteSubrubro = permission::firstOrNew(array('name' => 'delete_subrubro'));
        $deleteSubrubro->name         = 'delete_subrubro';
        $deleteSubrubro->display_name = 'Borrar Subrubros';
        $deleteSubrubro->description  = 'Borrar subrubros existentes';
        $deleteSubrubro->save();

        //Permisos Zona
        $createZona = permission::firstOrNew(array('name' => 'create_zona'));
        $createZona->name         = 'create_zona';
        $createZona->display_name = 'Crear Zonas';
        $createZona->description  = 'Crear nuevos zonas';
        $createZona->save();

        $editZona = permission::firstOrNew(array('name' => 'edit_zona'));
        $editZona->name         = 'edit_zona';
        $editZona->display_name = 'Editar Zonas';
        $editZona->description  = 'Editar zonas existentes';
        $editZona->save();

        $viewZona = permission::firstOrNew(array('name' => 'view_zona'));
        $viewZona->name         = 'view_zona';
        $viewZona->display_name = 'Ver Zonas';
        $viewZona->description  = 'Ver zonas existentes';
        $viewZona->save();

        $deleteZona = permission::firstOrNew(array('name' => 'delete_zona'));
        $deleteZona->name         = 'delete_zona';
        $deleteZona->display_name = 'Borrar Zonas';
        $deleteZona->description  = 'Borrar zonas existentes';
        $deleteZona->save();

        //Permisos Usuarios
        $createUsuario = permission::firstOrNew(array('name' => 'create_usuario'));
        $createUsuario->name         = 'create_usuario';
        $createUsuario->display_name = 'Crear Usuarios';
        $createUsuario->description  = 'Crear nuevos usuarios';
        $createUsuario->save();

        $editUsuario = permission::firstOrNew(array('name' => 'edit_usuario'));
        $editUsuario->name         = 'edit_usuario';
        $editUsuario->display_name = 'Editar Usuarios';
        $editUsuario->description  = 'Editar usuarios existentes';
        $editUsuario->save();

        $viewUsuario = permission::firstOrNew(array('name' => 'view_usuario'));
        $viewUsuario->name         = 'view_usuario';
        $viewUsuario->display_name = 'Ver Usuarios';
        $viewUsuario->description  = 'Ver usuarios existentes';
        $viewUsuario->save();

        $deleteUsuario = permission::firstOrNew(array('name' => 'delete_usuario'));
        $deleteUsuario->name         = 'delete_usuario';
        $deleteUsuario->display_name = 'Borrar Usuarios';
        $deleteUsuario->description  = 'Borrar usuarios existentes';
        $deleteUsuario->save();
    }
}