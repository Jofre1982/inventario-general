<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Datos mínimos para empezar. Se puede ejecutar varias veces:
     *   php artisan db:seed
     *
     * Para cargar productos, ventas y compras de ejemplo:
     *   php artisan db:seed --class=DemoSeeder
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class, // crea también los roles Admin y Cajero
            UsersTableSeeder::class,
            BusinessTableSeeder::class,
            PrinterTableSeeder::class,
            ClientSeeder::class,
        ]);
    }
}
