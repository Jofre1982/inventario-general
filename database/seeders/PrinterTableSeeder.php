<?php

namespace Database\Seeders;

use App\Models\Printer;
use Illuminate\Database\Seeder;

class PrinterTableSeeder extends Seeder
{
    public function run()
    {
        Printer::current();
    }
}
