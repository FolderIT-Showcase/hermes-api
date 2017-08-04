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

        //Permisos proveedores
        $createProveedor = permission::firstOrNew(array('name' => 'create_proveedor'));
        $createProveedor->name          = 'create_proveedor';
        $createProveedor->display_name  = 'Crear Proveedores';
        $createProveedor->description   = 'Crear nuevos proveedores';
        $createProveedor->save();

        $editProveedor = permission::firstOrNew(array('name' => 'edit_proveedor'));
        $editProveedor->name         = 'edit_proveedor';
        $editProveedor->display_name = 'Editar Proveedores';
        $editProveedor->description  = 'Editar proveedores existentes';
        $editProveedor->save();

        $viewProveedor = permission::firstOrNew(array('name' => 'view_proveedor'));
        $viewProveedor->name         = 'view_proveedor';
        $viewProveedor->display_name = 'Ver Proveedores';
        $viewProveedor->description  = 'Ver proveedores existentes';
        $viewProveedor->save();

        $deleteProveedor = permission::firstOrNew(array('name' => 'delete_proveedor'));
        $deleteProveedor->name         = 'delete_proveedor';
        $deleteProveedor->display_name = 'Borrar Proveedores';
        $deleteProveedor->description  = 'Borrar proveedores existentes';
        $deleteProveedor->save();
        
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

        //Permisos PeriodoFiscal
        $createPeriodoFiscal = permission::firstOrNew(array('name' => 'create_periodoFiscal'));
        $createPeriodoFiscal->name         = 'create_periodoFiscal';
        $createPeriodoFiscal->display_name = 'Crear Periodo Fiscal';
        $createPeriodoFiscal->description  = 'Crear nuevo periodo fiscal';
        $createPeriodoFiscal->save();

        $editPeriodoFiscal = permission::firstOrNew(array('name' => 'edit_periodoFiscal'));
        $editPeriodoFiscal->name         = 'edit_periodoFiscal';
        $editPeriodoFiscal->display_name = 'Editar Periodo Fiscal';
        $editPeriodoFiscal->description  = 'Editar periodo fiscal existente';
        $editPeriodoFiscal->save();

        $viewPeriodoFiscal = permission::firstOrNew(array('name' => 'view_periodoFiscal'));
        $viewPeriodoFiscal->name         = 'view_periodoFiscal';
        $viewPeriodoFiscal->display_name = 'Ver Periodo Fiscal';
        $viewPeriodoFiscal->description  = 'Ver periodos fiscales existentes';
        $viewPeriodoFiscal->save();

        $deletePeriodoFiscal = permission::firstOrNew(array('name' => 'delete_periodoFiscal'));
        $deletePeriodoFiscal->name         = 'delete_periodoFiscal';
        $deletePeriodoFiscal->display_name = 'Borrar Periodo Fiscal';
        $deletePeriodoFiscal->description  = 'Borrar periodo fiscal existente';
        $deletePeriodoFiscal->save();

        //Permisos TipoRetenciones
        $createTipoRetencion = permission::firstOrNew(array('name' => 'create_tipoRetencion'));
        $createTipoRetencion->name         = 'create_tipoRetencion';
        $createTipoRetencion->display_name = 'Crear tipoRetencion';
        $createTipoRetencion->description  = 'Crear nuevo tipo de retencion';
        $createTipoRetencion->save();

        $editTipoRetencion = permission::firstOrNew(array('name' => 'edit_tipoRetencion'));
        $editTipoRetencion->name         = 'edit_tipoRetencion';
        $editTipoRetencion->display_name = 'Editar tipoRetencion';
        $editTipoRetencion->description  = 'Editar tipo de retencion existente';
        $editTipoRetencion->save();

        $viewTipoRetencion = permission::firstOrNew(array('name' => 'view_tipoRetencion'));
        $viewTipoRetencion->name         = 'view_tipoRetencion';
        $viewTipoRetencion->display_name = 'Ver tipoRetencion';
        $viewTipoRetencion->description  = 'Ver tipos de retencion existentes';
        $viewTipoRetencion->save();

        $deleteTipoRetencion = permission::firstOrNew(array('name' => 'delete_tipoRetencion'));
        $deleteTipoRetencion->name         = 'delete_tipoRetencion';
        $deleteTipoRetencion->display_name = 'Borrar tipoRetencion';
        $deleteTipoRetencion->description  = 'Borrar tipo de retencion existente';
        $deleteTipoRetencion->save();

        //Permisos FacturaCompra
        $createFacturaCompra = permission::firstOrNew(array('name' => 'create_facturaCompra'));
        $createFacturaCompra->name         = 'create_facturaCompra';
        $createFacturaCompra->display_name = 'Crear Facturas de Compra';
        $createFacturaCompra->description  = 'Crear nuevas facturas de compra';
        $createFacturaCompra->save();

        $editFacturaCompra = permission::firstOrNew(array('name' => 'edit_facturaCompra'));
        $editFacturaCompra->name         = 'edit_facturaCompra';
        $editFacturaCompra->display_name = 'Editar Facturas de Compra';
        $editFacturaCompra->description  = 'Editar facturas de compra existentes';
        $editFacturaCompra->save();

        $viewFacturaCompra = permission::firstOrNew(array('name' => 'view_facturaCompra'));
        $viewFacturaCompra->name         = 'view_facturaCompra';
        $viewFacturaCompra->display_name = 'Ver Facturas de Compra';
        $viewFacturaCompra->description  = 'Ver facturas de compra existentes';
        $viewFacturaCompra->save();

        $deleteFacturaCompra = permission::firstOrNew(array('name' => 'delete_facturaCompra'));
        $deleteFacturaCompra->name         = 'delete_facturaCompra';
        $deleteFacturaCompra->display_name = 'Borrar Facturas de Compra';
        $deleteFacturaCompra->description  = 'Borrar facturas de compra existentes';
        $deleteFacturaCompra->save();

        //Permisos NotaCreditoCompra
        $createNotaCreditoCompra = permission::firstOrNew(array('name' => 'create_notaCreditoCompra'));
        $createNotaCreditoCompra->name         = 'create_notaCreditoCompra';
        $createNotaCreditoCompra->display_name = 'Crear Notas de Credito de Compra';
        $createNotaCreditoCompra->description  = 'Crear nuevas notas de credito de compra';
        $createNotaCreditoCompra->save();

        $editNotaCreditoCompra = permission::firstOrNew(array('name' => 'edit_notaCreditoCompra'));
        $editNotaCreditoCompra->name         = 'edit_notaCreditoCompra';
        $editNotaCreditoCompra->display_name = 'Editar Notas de Credito de Compra';
        $editNotaCreditoCompra->description  = 'Editar notas de credito de compra existentes';
        $editNotaCreditoCompra->save();

        $viewNotaCreditoCompra = permission::firstOrNew(array('name' => 'view_notaCreditoCompra'));
        $viewNotaCreditoCompra->name         = 'view_notaCreditoCompra';
        $viewNotaCreditoCompra->display_name = 'Ver Notas de Credito de Compra';
        $viewNotaCreditoCompra->description  = 'Ver notas de credito de compra existentes';
        $viewNotaCreditoCompra->save();

        $deleteNotaCreditoCompra = permission::firstOrNew(array('name' => 'delete_notaCreditoCompra'));
        $deleteNotaCreditoCompra->name         = 'delete_notaCreditoCompra';
        $deleteNotaCreditoCompra->display_name = 'Borrar Notas de Credito de Compra';
        $deleteNotaCreditoCompra->description  = 'Borrar notas de credito de compra existentes';
        $deleteNotaCreditoCompra->save();

        //Permisos NotaDebitoCompra
        $createNotaDebitoCompra = permission::firstOrNew(array('name' => 'create_notaDebitoCompra'));
        $createNotaDebitoCompra->name         = 'create_notaDebitoCompra';
        $createNotaDebitoCompra->display_name = 'Crear Notas de Debito de Compra';
        $createNotaDebitoCompra->description  = 'Crear nuevas notas de debito de compra';
        $createNotaDebitoCompra->save();

        $editNotaDebitoCompra = permission::firstOrNew(array('name' => 'edit_notaDebitoCompra'));
        $editNotaDebitoCompra->name         = 'edit_notaDebitoCompra';
        $editNotaDebitoCompra->display_name = 'Editar Notas de Debito de Compra';
        $editNotaDebitoCompra->description  = 'Editar notas de debito de compra existentes';
        $editNotaDebitoCompra->save();

        $viewNotaDebitoCompra = permission::firstOrNew(array('name' => 'view_notaDebitoCompra'));
        $viewNotaDebitoCompra->name         = 'view_notaDebitoCompra';
        $viewNotaDebitoCompra->display_name = 'Ver Notas de Debito de Compra';
        $viewNotaDebitoCompra->description  = 'Ver notas de debito de compra existentes';
        $viewNotaDebitoCompra->save();

        $deleteNotaDebitoCompra = permission::firstOrNew(array('name' => 'delete_notaDebitoCompra'));
        $deleteNotaDebitoCompra->name         = 'delete_notaDebitoCompra';
        $deleteNotaDebitoCompra->display_name = 'Borrar Notas de Debito de Compra';
        $deleteNotaDebitoCompra->description  = 'Borrar notas de debito de compra existentes';
        $deleteNotaDebitoCompra->save();

        //Permisos banco
        $createBanco = Permission::firstOrNew(array('name' => 'create_banco'));
        $createBanco->name         = 'create_banco';
        $createBanco->display_name = 'Crear Bancos';
        $createBanco->description  = 'Crear nuevos bancos';
        $createBanco->save();

        $editBanco = permission::firstOrNew(array('name' => 'edit_banco'));
        $editBanco->name         = 'edit_banco';
        $editBanco->display_name = 'Editar Bancos';
        $editBanco->description  = 'Editar bancos existentes';
        $editBanco->save();

        $viewBanco = permission::firstOrNew(array('name' => 'view_banco'));
        $viewBanco->name         = 'view_banco';
        $viewBanco->display_name = 'Ver Bancos';
        $viewBanco->description  = 'Ver bancos existentes';
        $viewBanco->save();

        $deleteBanco = permission::firstOrNew(array('name' => 'delete_banco'));
        $deleteBanco->name         = 'delete_banco';
        $deleteBanco->display_name = 'Borrar Bancos';
        $deleteBanco->description  = 'Borrar bancos existentes';
        $deleteBanco->save();

        //Permisos tipo tarjeta
        $createTipoTarjeta = Permission::firstOrNew(array('name' => 'create_tipo_tarjeta'));
        $createTipoTarjeta->name         = 'create_tipo_tarjeta';
        $createTipoTarjeta->display_name = 'Crear Tipos de Tarjeta';
        $createTipoTarjeta->description  = 'Crear nuevos tipos de tarjeta';
        $createTipoTarjeta->save();

        $editTipoTarjeta = permission::firstOrNew(array('name' => 'edit_tipo_tarjeta'));
        $editTipoTarjeta->name         = 'edit_tipo_tarjeta';
        $editTipoTarjeta->display_name = 'Editar Tipos Tarjeta';
        $editTipoTarjeta->description  = 'Editar tipos de tarjeta existentes';
        $editTipoTarjeta->save();

        $viewTipoTarjeta = permission::firstOrNew(array('name' => 'view_tipo_tarjeta'));
        $viewTipoTarjeta->name         = 'view_tipo_tarjeta';
        $viewTipoTarjeta->display_name = 'Ver Tipos de Tarjeta';
        $viewTipoTarjeta->description  = 'Ver tipos de tarjeta existentes';
        $viewTipoTarjeta->save();

        $deleteTipoTarjeta = permission::firstOrNew(array('name' => 'delete_tipo_tarjeta'));
        $deleteTipoTarjeta->name         = 'delete_tipo_tarjeta';
        $deleteTipoTarjeta->display_name = 'Borrar Tipos de Tarjeta';
        $deleteTipoTarjeta->description  = 'Borrar tipos de tarjeta existentes';
        $deleteTipoTarjeta->save();

        //Permisos cuenta bancaria
        $createCuentaBancaria = Permission::firstOrNew(array('name' => 'create_cuenta_bancaria'));
        $createCuentaBancaria->name         = 'create_cuenta_bancaria';
        $createCuentaBancaria->display_name = 'Crear Cuentas Bancarias';
        $createCuentaBancaria->description  = 'Crear nuevas cuentas bancarias';
        $createCuentaBancaria->save();

        $editCuentaBancaria = permission::firstOrNew(array('name' => 'edit_cuenta_bancaria'));
        $editCuentaBancaria->name         = 'edit_cuenta_bancaria';
        $editCuentaBancaria->display_name = 'Editar Cuentas Bancaria';
        $editCuentaBancaria->description  = 'Editar cuentas bancarias existentes';
        $editCuentaBancaria->save();

        $viewCuentaBancaria = permission::firstOrNew(array('name' => 'view_cuenta_bancaria'));
        $viewCuentaBancaria->name         = 'view_cuenta_bancaria';
        $viewCuentaBancaria->display_name = 'Ver Cuentas Bancarias';
        $viewCuentaBancaria->description  = 'Ver cuentas bancarias existentes';
        $viewCuentaBancaria->save();

        $deleteCuentaBancaria = permission::firstOrNew(array('name' => 'delete_cuenta_bancaria'));
        $deleteCuentaBancaria->name         = 'delete_cuenta_bancaria';
        $deleteCuentaBancaria->display_name = 'Borrar Cuentas Bancarias';
        $deleteCuentaBancaria->description  = 'Borrar cuentas bancarias existentes';
        $deleteCuentaBancaria->save();

        //Permisos Tarjeta
        $createTarjeta = permission::firstOrNew(array('name' => 'create_tarjeta'));
        $createTarjeta->name         = 'create_tarjeta';
        $createTarjeta->display_name = 'Crear Tarjetas';
        $createTarjeta->description  = 'Crear nuevos tarjetas';
        $createTarjeta->save();

        $editTarjeta = permission::firstOrNew(array('name' => 'edit_tarjeta'));
        $editTarjeta->name         = 'edit_tarjeta';
        $editTarjeta->display_name = 'Editar Tarjetas';
        $editTarjeta->description  = 'Editar tarjetas existentes';
        $editTarjeta->save();

        $viewTarjeta = permission::firstOrNew(array('name' => 'view_tarjeta'));
        $viewTarjeta->name         = 'view_tarjeta';
        $viewTarjeta->display_name = 'Ver Tarjetas';
        $viewTarjeta->description  = 'Ver tarjetas existentes';
        $viewTarjeta->save();

        $deleteTarjeta = permission::firstOrNew(array('name' => 'delete_tarjeta'));
        $deleteTarjeta->name         = 'delete_tarjeta';
        $deleteTarjeta->display_name = 'Borrar Tarjetas';
        $deleteTarjeta->description  = 'Borrar tarjetas existentes';
        $deleteTarjeta->save();

        //Permisos Deposito
        $createDeposito = permission::firstOrNew(array('name' => 'create_deposito'));
        $createDeposito->name         = 'create_deposito';
        $createDeposito->display_name = 'Crear Depositos';
        $createDeposito->description  = 'Crear nuevos depositos';
        $createDeposito->save();

        $editDeposito = permission::firstOrNew(array('name' => 'edit_deposito'));
        $editDeposito->name         = 'edit_deposito';
        $editDeposito->display_name = 'Editar Depositos';
        $editDeposito->description  = 'Editar depositos existentes';
        $editDeposito->save();

        $viewDeposito = permission::firstOrNew(array('name' => 'view_deposito'));
        $viewDeposito->name         = 'view_deposito';
        $viewDeposito->display_name = 'Ver Depositos';
        $viewDeposito->description  = 'Ver depositos existentes';
        $viewDeposito->save();

        $deleteDeposito = permission::firstOrNew(array('name' => 'delete_deposito'));
        $deleteDeposito->name         = 'delete_deposito';
        $deleteDeposito->display_name = 'Borrar Depositos';
        $deleteDeposito->description  = 'Borrar depositos existentes';
        $deleteDeposito->save();

        //Permisos Cheque Terceros
        $createChequeTercero = permission::firstOrNew(array('name' => 'create_cheque_tercero'));
        $createChequeTercero->name         = 'create_cheque_tercero';
        $createChequeTercero->display_name = 'Crear Cheques de Terceros';
        $createChequeTercero->description  = 'Crear nuevos cheques de terceros';
        $createChequeTercero->save();

        $editChequeTercero = permission::firstOrNew(array('name' => 'edit_cheque_tercero'));
        $editChequeTercero->name         = 'edit_cheque_tercero';
        $editChequeTercero->display_name = 'Editar Cheques de Terceros';
        $editChequeTercero->description  = 'Editar cheques de terceros existentes';
        $editChequeTercero->save();

        $viewChequeTercero = permission::firstOrNew(array('name' => 'view_cheque_tercero'));
        $viewChequeTercero->name         = 'view_cheque_tercero';
        $viewChequeTercero->display_name = 'Ver Cheque de Terceros';
        $viewChequeTercero->description  = 'Ver cheques de terceros existentes';
        $viewChequeTercero->save();

        $deleteChequeTercero = permission::firstOrNew(array('name' => 'delete_cheque_tercero'));
        $deleteChequeTercero->name         = 'delete_cheque_tercero';
        $deleteChequeTercero->display_name = 'Borrar Cheques de Terceros';
        $deleteChequeTercero->description  = 'Borrar cheques de terceros existentes';
        $deleteChequeTercero->save();
    }
}