<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Business;
use Illuminate\Support\Facades\DB;

class BusinessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         //Esto está mal
         Business::table('users')->insert([
            'name' => 'Nombre de la empresa',
            'description' => 'Descripcion corta dela empresa',
            'logo'=> 'Logo.png',
            'mail'=> 'Ejemplo@gmail.com',
            'Address' => 'Barrio Primavera',
            'nit' => '981123654-0',

        ]);*/

        //FORMA 1
        DB::table('businesses')->insert([
            'name' => 'Nombre de la empresa',
            'description' => 'Descripcion corta dela empresa',
            'logo'=> 'Logo.png',
            'mail'=> 'Ejemplo@gmail.com',
            'Address' => 'Barrio Primavera',
            'nit' => '981123654-0',

        ]);

        //FORMA 2
        Business::create([
            'name' => 'Nombre de la empresa 2',
            'description' => 'Descripcion corta dela empresa2',
            'logo'=> 'Logo2.png',
            'mail'=> 'Ejemplo2@gmail.com',
            'Address' => 'Barrio Primavera2',
            'nit' => '981123654-2',

        ]);
    }
}
