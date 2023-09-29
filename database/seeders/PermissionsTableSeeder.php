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
        //Categorias
        Permissions::create([
            'name'=>'Navegar categorias',
            'slug'=>'categories.index',
            'description'=>'Lista y navega por todas las categorias del sistema',
        ]);
        Permissions::create([
            'name'=>'Ver detalle de categoria',
            'slug'=>'categories.show',
            'description'=>'Ver detalle de cada categoria del sistema',
        ]);
        Permissions::create([
            'name'=>'Edicion de categorias',
            'slug'=>'categories.edit',
            'description'=>'Editar cualquier dato de una categoria del sistema',
        ]);
        Permissions::create([
            'name'=>'Creacion de categorias',
            'slug'=>'categories.create',
            'description'=>'Crea cualquier dato de una categorias del sistema',
        ]);
        Permissions::create([
            'name'=>'Eliminar categorias',
            'slug'=>'categories.destroy',
            'description'=>'Eliminar cualquier dato de una categorias del sistema',
        ]); 
        //Clientes
        Permissions::create([
            'name'=>'Navegar por clientes',
            'slug'=>'clients.index',
            'description'=>'Lista y navega por todos los clientes del sistema',
        ]);
        Permissions::create([
            'name'=>'Ver detalle de clientes',
            'slug'=>'clients.show',
            'description'=>'Ver detalle de cada cliente del sistema',
        ]);
        Permissions::create([
            'name'=>'Edicion de clientes',
            'slug'=>'categories.edit',
            'description'=>'Editar cualquier dato de un cliente del sistema',
        ]);
        Permissions::create([
            'name'=>'Creacion de clientes',
            'slug'=>'clients.create',
            'description'=>'Crea cualquier dato de un cliente del sistema',
        ]);
        Permissions::create([
            'name'=>'Eliminar clientes',
            'slug'=>'clients.destroy',
            'description'=>'Eliminar cualquier dato de una categorias del sistema',
        ]); 
    }
}
