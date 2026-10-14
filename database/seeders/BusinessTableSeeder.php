<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;

class BusinessTableSeeder extends Seeder
{
    public function run()
    {
        if (Business::exists()) {
            return;
        }

        Business::create([
            'name' => 'Nombre de la empresa',
            'description' => 'Descripción corta de la empresa',
            'logo' => '',
            'mail' => 'ejemplo@gmail.com',
            'address' => 'Barrio Primavera',
            'nit' => '981123654-2',
        ]);
    }
}
