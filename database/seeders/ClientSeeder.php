<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /** Cliente genérico para ventas de mostrador. */
    public function run()
    {
        Client::firstOrCreate(['document' => '222222222222'], [
            'name' => 'CONSUMIDOR FINAL',
        ]);
    }
}
