<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
/*
        $createCliente =        Permission::where('name', 'create_cliente')->first();
        $editCliente =          Permission::where('name', 'edit_cliente')->first();
        $viewCliente =          Permission::where('name', 'view_cliente')->first();
        $deleteCliente =        Permission::where('name', 'delete_cliente')->first();

        $createArticulo =       Permission::where('name', 'create_articulo')->first();
        $editArticulo =         Permission::where('name', 'edit_articulo')->first();
        $viewArticulo =         Permission::where('name', 'view_articulo')->first();
        $deleteArticulo =       Permission::where('name', 'delete_articulo')->first();

        $createVendedor =       Permission::where('name', 'create_vendedor')->first();
        $editVendedor =         Permission::where('name', 'edit_vendedor')->first();
        $viewVendedor =         Permission::where('name', 'view_vendedor')->first();
        $deleteVendedor =       Permission::where('name', 'delete_vendedor')->first();

        $createListaPrecios =   Permission::where('name', 'create_lista_precios')->first();
        $editListaPrecios =     Permission::where('name', 'edit_lista_precios')->first();
        $viewListaPrecios =     Permission::where('name', 'view_lista_precios')->first();
        $deleteListaPrecios =   Permission::where('name', 'delete_lista_precios')->first();

        $viewCtaCte =           Permission::where('name', 'view_cta_cte')->first();

        $createFactura =        Permission::where('name', 'create_factura')->first();
        $editFactura =          Permission::where('name', 'edit_factura')->first();
        $viewFactura =          Permission::where('name', 'view_factura')->first();
        $deleteFactura =        Permission::where('name', 'delete_factura')->first();

        $createPresupuesto =    Permission::where('name', 'create_presupuesto')->first();
        $editPresupuesto =      Permission::where('name', 'edit_presupuesto')->first();
        $viewPresupuesto =      Permission::where('name', 'view_presupuesto')->first();
        $deletePresupuesto =    Permission::where('name', 'delete_presupuesto')->first();

        $createNotaDebito =     Permission::where('name', 'create_nota_debito')->first();
        $editNotaDebito =       Permission::where('name', 'edit_nota_debito')->first();
        $viewNotaDebito =       Permission::where('name', 'view_nota_debito')->first();
        $deleteNotaDebito =     Permission::where('name', 'delete_nota_debito')->first();

        $createNotaCredito =    Permission::where('name', 'create_nota_credito')->first();
        $editNotaCredito =      Permission::where('name', 'edit_nota_credito')->first();
        $viewNotaCredito =      Permission::where('name', 'view_nota_credito')->first();
        $deleteNotaCredito =    Permission::where('name', 'delete_nota_credito')->first();

        $createMarca =          Permission::where('name', 'create_marca')->first();
        $editMarca =            Permission::where('name', 'edit_marca')->first();
        $viewMarca =            Permission::where('name', 'view_marca')->first();
        $deleteMarca =          Permission::where('name', 'delete_marca')->first();

        $createRubro =          Permission::where('name', 'create_rubro')->first();
        $editRubro =            Permission::where('name', 'edit_rubro')->first();
        $viewRubro =            Permission::where('name', 'view_rubro')->first();
        $deleteRubro =          Permission::where('name', 'delete_rubro')->first();

        $createSubrubro =       Permission::where('name', 'create_subrubro')->first();
        $editSubrubro =         Permission::where('name', 'edit_subrubro')->first();
        $viewSubrubro =         Permission::where('name', 'view_subrubro')->first();
        $deleteSubrubro =       Permission::where('name', 'delete_subrubro')->first();

        $createZona =           Permission::where('name', 'create_zona')->first();
        $editZona =             Permission::where('name', 'edit_zona')->first();
        $viewZona =             Permission::where('name', 'view_zona')->first();
        $deleteZona =           Permission::where('name', 'delete_zona')->first();
*/

        $dev = Role::where('name', 'dev')->first();
        //Un desarrollador tiene todos los permisos
        $permisosDev = Permission::all();
        $dev->detachPermissions($permisosDev);
        $dev->attachPermissions($permisosDev);
    }
}