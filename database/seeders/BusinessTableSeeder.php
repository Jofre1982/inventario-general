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
