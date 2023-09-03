<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Business;

class BusinessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Business::table('users')->insert([
            'name' => 'Nombre de la empresa',
            'description' => 'Descripcion corta dela empresa',
            'logo'=> 'Logo.png',
            'mail'=> 'Ejemplo@gmail.com',
            'Address' => 'Barrio Primavera',
            'nit' => '981123654-0',

        ]);
    }
}
