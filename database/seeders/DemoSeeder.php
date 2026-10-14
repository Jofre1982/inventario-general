<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Provider;
use App\Models\User;
use App\Services\InventoryService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Datos de ejemplo para probar el sistema (no usar en producción):
 *   php artisan db:seed --class=DemoSeeder
 */
class DemoSeeder extends Seeder
{
    public function run(InventoryService $inventory)
    {
        $this->call(DatabaseSeeder::class);

        $provider = Provider::firstOrCreate(['nit' => '900123456-1'], [
            'name' => 'Distribuidora La Economía',
            'email' => 'ventas@laeconomia.co',
            'phone' => '6015551234',
            'adress' => 'Cra 10 # 20-30, Bogotá',
        ]);

        $catalog = [
            'Abarrotes' => [
                ['7702001000011', 'Arroz Diana 1 kg', 4800],
                ['7702001000028', 'Aceite Premier 1 L', 12900],
                ['7702001000035', 'Azúcar Manuelita 1 kg', 4500],
                ['7702001000042', 'Panela Doña Pepa 500 g', 3200],
                ['7702001000059', 'Café Sello Rojo 500 g', 16900],
            ],
            'Lácteos' => [
                ['7702001000066', 'Leche Alquería 1 L', 4600],
                ['7702001000073', 'Queso campesino 500 g', 11500],
                ['7702001000080', 'Huevos AA x 30', 18500],
            ],
            'Bebidas' => [
                ['7702001000097', 'Gaseosa Postobón 1.5 L', 5200],
                ['7702001000103', 'Agua Cristal 600 ml', 1800],
            ],
            'Aseo' => [
                ['7702001000110', 'Jabón Rey x 3', 6900],
                ['7702001000127', 'Papel higiénico Familia x 4', 9800],
            ],
        ];

        $products = collect();
        foreach ($catalog as $categoryName => $items) {
            $category = Category::firstOrCreate(['name' => $categoryName]);
            foreach ($items as [$code, $name, $price]) {
                $products->push(Product::firstOrCreate(['code' => $code], [
                    'name' => $name,
                    'sell_price' => $price,
                    'min_stock' => 5,
                    'category_id' => $category->id,
                    'provider_id' => $provider->id,
                ]));
            }
        }

        $admin = User::where('email', 'admin@black.com')->firstOrFail();

        // Compra inicial: entra stock de todos los productos (costo ~ 75% del precio).
        $inventory->registerPurchase($provider->id, $admin->id, 0, $products->map(fn ($p, $i) => [
            'product_id' => $p->id,
            'quantity' => $i % 4 === 0 ? 6 : 40,
            'price' => round($p->sell_price * 0.75, -2),
        ])->all());

        // Algunas ventas en los últimos días para que el inicio y los reportes tengan datos.
        $client = Client::where('document', '222222222222')->first();
        $today = Carbon::today();
        for ($day = 6; $day >= 1; $day--) {
            Carbon::setTestNow($today->copy()->subDays($day)->setTime(10 + $day, 15));
            $inventory->registerSale($client->id, $admin->id, 0, $products->slice(($day * 3) % 12, 3)->values()->map(fn ($p) => [
                'product_id' => $p->id,
                'quantity' => 1,
                'discount' => 0,
            ])->all());
        }
        Carbon::setTestNow();
    }
}
