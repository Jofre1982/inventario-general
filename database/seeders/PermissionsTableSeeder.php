<?php

namespace Database\Seeders;

use Fxneiram\Shinobi\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        //Usuarios
        Permission::create([
            'name'=>'Navegar usuarios',
            'slug'=>'users.index',
            'description'=>'Lista y navega por todas los usuarios del sistema',
        ]);
        Permission::create([
            'name'=>'Ver detalle de usuario',
            'slug'=>'users.show',
            'description'=>'Ver detalle de cada usuario del sistema',
        ]);
        Permission::create([
            'name'=>'Edicion de usuarios',
            'slug'=>'users.edit',
            'description'=>'Editar cualquier dato de un usuario del sistema',
        ]);
        Permission::create([
            'name'=>'Creacion de usuarios',
            'slug'=>'users.create',
            'description'=>'Crea cualquier dato de un usuario del sistema',
        ]);
        Permission::create([
            'name'=>'Eliminar usuarios',
            'slug'=>'users.destroy',
            'description'=>'Eliminar cualquier dato de un usuario del sistema',
        ]);

        //Roles
        Permission::create([
            'name'=>'Navegar roles',
            'slug'=>'roles.index',
            'description'=>'Lista y navega por todas los roles del sistema',
        ]);
        Permission::create([
            'name'=>'Ver detalle de rol',
            'slug'=>'roles.show',
            'description'=>'Ver detalle de cada rol del sistema',
        ]);
        Permission::create([
            'name'=>'Edicion de roles',
            'slug'=>'roles.edit',
            'description'=>'Editar cualquier dato de un rol del sistema',
        ]);
        Permission::create([
            'name'=>'Creacion de roles',
            'slug'=>'roles.create',
            'description'=>'Crea cualquier dato de un rol del sistema',
        ]);
        Permission::create([
            'name'=>'Eliminar roles',
            'slug'=>'roles.destroy',
            'description'=>'Eliminar cualquier dato de un rol del sistema',
        ]);

        //Categorias
        Permission::create([
            'name'=>'Navegar categorias',
            'slug'=>'categories.index',
            'description'=>'Lista y navega por todas las categorias del sistema',
        ]);
        Permission::create([
            'name'=>'Ver detalle de categoria',
            'slug'=>'categories.show',
            'description'=>'Ver detalle de cada categoria del sistema',
        ]);
        Permission::create([
            'name'=>'Edicion de categorias',
            'slug'=>'categories.edit',
            'description'=>'Editar cualquier dato de una categoria del sistema',
        ]);
        Permission::create([
            'name'=>'Creacion de categorias',
            'slug'=>'categories.create',
            'description'=>'Crea cualquier dato de una categorias del sistema',
        ]);
        Permission::create([
            'name'=>'Eliminar categorias',
            'slug'=>'categories.destroy',
            'description'=>'Eliminar cualquier dato de una categorias del sistema',
        ]); 
        //Clientes
        Permission::create([
            'name'=>'Navegar por clientes',
            'slug'=>'clients.index',
            'description'=>'Lista y navega por todos los clientes del sistema',
        ]);
        Permission::create([
            'name'=>'Ver detalle de clientes',
            'slug'=>'clients.show',
            'description'=>'Ver detalle de cada cliente del sistema',
        ]);
        Permission::create([
            'name'=>'Edicion de clientes',
            'slug'=>'calients.edit',
            'description'=>'Editar cualquier dato de un cliente del sistema',
        ]);
        Permission::create([
            'name'=>'Creacion de clientes',
            'slug'=>'clients.create',
            'description'=>'Crea cualquier dato de un cliente del sistema',
        ]);
        Permission::create([
            'name'=>'Eliminar clientes',
            'slug'=>'clients.destroy',
            'description'=>'Eliminar cualquier dato de un cliente del sistema',
        ]); 

         //Productos
         Permission::create([
            'name'=>'Navegar por productos',
            'slug'=>'products.index',
            'description'=>'Lista y navega por todos los productos del sistema',
        ]);
        Permission::create([
            'name'=>'Ver detalle de producto',
            'slug'=>'products.show',
            'description'=>'Ver detalle de cada producto del sistema',
        ]);
        Permission::create([
            'name'=>'Edicion de productos',
            'slug'=>'products.edit',
            'description'=>'Editar cualquier dato de un producto del sistema',
        ]);
        Permission::create([
            'name'=>'Creacion de productos',
            'slug'=>'products.create',
            'description'=>'Crea cualquier dato de un producto del sistema',
        ]);
        Permission::create([
            'name'=>'Eliminar productos',
            'slug'=>'products.destroy',
            'description'=>'Eliminar cualquier dato de un producto del sistema',
        ]); 

         //Proveedores
         Permission::create([
            'name'=>'Navegar por proveedores',
            'slug'=>'providers.index',
            'description'=>'Lista y navega por todos los proveedores del sistema',
        ]);
        Permission::create([
            'name'=>'Ver detalle de proveedor',
            'slug'=>'providers.show',
            'description'=>'Ver detalle de cada proveedor del sistema',
        ]);
        Permission::create([
            'name'=>'Edicion de proveedores',
            'slug'=>'providers.edit',
            'description'=>'Editar cualquier dato de un proveedor del sistema',
        ]);
        Permission::create([
            'name'=>'Creacion de proveedores',
            'slug'=>'providers.create',
            'description'=>'Crea cualquier dato de un proveedor del sistema',
        ]);
        Permission::create([
            'name'=>'Eliminar proveedores',
            'slug'=>'providers.destroy',
            'description'=>'Eliminar cualquier dato de un proveedor del sistema',
        ]); 

        //Compras
        Permission::create([
            'name'=>'Navegar por compras',
            'slug'=>'purchases.index',
            'description'=>'Lista y navega por todas las compras del sistema',
        ]);
        Permission::create([
            'name'=>'Ver detalle de compra',
            'slug'=>'purchases.show',
            'description'=>'Ver detalle de cada compra del sistema',
        ]);
        Permission::create([
            'name'=>'Creacion de compras',
            'slug'=>'purchases.create',
            'description'=>'Crea cualquier dato de una compra del sistema',
        ]); 

        //Ventas
        Permission::create([
            'name'=>'Navegar por ventas',
            'slug'=>'sales.index',
            'description'=>'Lista y navega por todas las ventas del sistema',
        ]);
        Permission::create([
            'name'=>'Ver detalle deventa',
            'slug'=>'sales.show',
            'description'=>'Ver detalle de cada venta del sistema',
        ]);
        Permission::create([
            'name'=>'Creacion de ventas',
            'slug'=>'sales.create',
            'description'=>'Crea cualquier dato de una venta del sistema',
        ]);

        //PDF
        Permission::create([
            'name'=>'Descargar PDF reporte compras',
            'slug'=>'purchases.pdf',
            'description'=>'Puede descargar todos los reportes de compras en PDF',
        ]);
        Permission::create([
            'name'=>'Descargar PDF reporte ventas',
            'slug'=>'sales.pdf',
            'description'=>'Puede descargar todos los reportes de ventas en PDF',
        ]);

        //Imprimir
        Permission::create([
            'name'=>'Imprimir boleta de venta',
            'slug'=>'sales.print',
            'description'=>'Puede imprimir boletas de todas ls ventas',
        ]);

        //Empresa
        Permission::create([
            'name'=>'Ver datos de la empresa',
            'slug'=>'business.index',
            'description'=>'Navega por los datos de la empresa',
        ]);
        Permission::create([
            'name'=>'Edicion de empresa',
            'slug'=>'business.edit',
            'description'=>'Editar cualquier dato de la empresa',
        ]);

        //Impresora
        Permission::create([
            'name'=>'Ver datos de la impresora',
            'slug'=>'printer.index',
            'description'=>'Navega por los datos de la impresora',
        ]);
        Permission::create([
            'name'=>'Edicion de impresora',
            'slug'=>'printer.edit',
            'description'=>'Editar cualquier dato de la impresora',
        ]);
        
        //Upload
        Permission::create([
            'name'=>'Subir un archivo de compra',
            'slug'=>'upload.purchases',
            'description'=>'Puede subir comprobantes de una compra',
        ]);

        //Cambios de estado
        Permission::create([
            'name'=>'Cambiar estado de producto',
            'slug'=>'change.status.products',
            'description'=>'Permite cambiar el estado de un producto',
        ]);
        Permission::create([
            'name'=>'Cambiar estado de compra',
            'slug'=>'change.status.purchases',
            'description'=>'Permite cambiar el estado de una compra',
        ]);
        Permission::create([
            'name'=>'Cambiar estado de ventas',
            'slug'=>'change.status.sales',
            'description'=>'Permite cambiar el estado de una venta',
        ]);

        //Reportes
        Permission::create([
            'name'=>'Reportes por dia',
            'slug'=>'report.day',
            'description'=>'Permite ver los reportes de ventas por dia',
        ]);
        Permission::create([
            'name'=>'Reportes por fechas',
            'slug'=>'report.date',
            'description'=>'Permite ver los reportes por un rango de fechas de las ventas ',
        ]);

    }
}
