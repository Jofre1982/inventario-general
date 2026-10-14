<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Toda operación que mueve el inventario pasa por aquí.
 *
 * Reglas:
 *  - Una venta válida descuenta stock; anularla lo devuelve.
 *  - Una compra válida suma stock; anularla lo descuenta.
 *  - Nunca se deja un producto con stock negativo.
 *  - Los totales se calculan en el servidor con los precios de la base de datos,
 *    no con lo que envía el navegador.
 *
 * Cada operación corre en una transacción y bloquea las filas de los productos
 * (lockForUpdate) para que dos cajas vendiendo al mismo tiempo no dejen el stock mal.
 */
class InventoryService
{
    /**
     * @param  array  $items  [['product_id' => 1, 'quantity' => 2, 'discount' => 0], ...]
     */
    public function registerSale(int $clientId, int $userId, float $taxPercent, array $items): Sale
    {
        $items = $this->groupItems($items, ['discount']);

        return DB::transaction(function () use ($clientId, $userId, $taxPercent, $items) {
            $products = $this->lockProducts(array_keys($items));
            $lines = [];
            $subtotal = 0;

            foreach ($items as $productId => $item) {
                $product = $products[$productId];

                if (! $product->isActive()) {
                    $this->fail("El producto «{$product->name}» está desactivado.");
                }
                if ($product->stock < $item['quantity']) {
                    $this->fail("Stock insuficiente para «{$product->name}»: hay {$product->stock} y se pidieron {$item['quantity']}.");
                }

                $discount = min(max((float) ($item['discount'] ?? 0), 0), 100);
                $gross = $item['quantity'] * $product->sell_price;
                $subtotal += $gross - $gross * $discount / 100;

                $lines[] = [
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $product->sell_price,
                    'discount' => $discount,
                ];

                $product->decrement('stock', $item['quantity']);
            }

            $sale = Sale::create([
                'client_id' => $clientId,
                'user_id' => $userId,
                'sale_date' => Carbon::now(),
                'tax' => $taxPercent,
                'total' => $this->totalWithTax($subtotal, $taxPercent),
                'status' => Sale::VALID,
            ]);
            $sale->saleDetails()->createMany($lines);

            return $sale;
        });
    }

    /**
     * @param  array  $items  [['product_id' => 1, 'quantity' => 10, 'price' => 2500], ...]
     */
    public function registerPurchase(int $providerId, int $userId, float $taxPercent, array $items): Purchase
    {
        $items = $this->groupItems($items, ['price']);

        return DB::transaction(function () use ($providerId, $userId, $taxPercent, $items) {
            $products = $this->lockProducts(array_keys($items));
            $lines = [];
            $subtotal = 0;

            foreach ($items as $productId => $item) {
                $price = max((float) $item['price'], 0);
                $subtotal += $item['quantity'] * $price;

                $lines[] = [
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                ];

                $products[$productId]->increment('stock', $item['quantity']);
            }

            $purchase = Purchase::create([
                'provider_id' => $providerId,
                'user_id' => $userId,
                'purchase_date' => Carbon::now(),
                'tax' => $taxPercent,
                'total' => $this->totalWithTax($subtotal, $taxPercent),
                'status' => Purchase::VALID,
            ]);
            $purchase->purchaseDetails()->createMany($lines);

            return $purchase;
        });
    }

    /** Anula una venta válida (devuelve el stock) o reactiva una anulada (lo vuelve a descontar). */
    public function toggleSale(Sale $sale): Sale
    {
        return DB::transaction(function () use ($sale) {
            $sale = Sale::whereKey($sale->id)->lockForUpdate()->firstOrFail();
            $quantities = $this->quantitiesByProduct($sale->saleDetails);
            $products = $this->lockProducts(array_keys($quantities));

            if ($sale->isValid()) {
                foreach ($quantities as $productId => $quantity) {
                    $products[$productId]->increment('stock', $quantity);
                }
                $sale->update(['status' => Sale::CANCELED]);
            } else {
                foreach ($quantities as $productId => $quantity) {
                    if ($products[$productId]->stock < $quantity) {
                        $this->fail("No se puede reactivar la venta: no hay stock suficiente de «{$products[$productId]->name}».");
                    }
                }
                foreach ($quantities as $productId => $quantity) {
                    $products[$productId]->decrement('stock', $quantity);
                }
                $sale->update(['status' => Sale::VALID]);
            }

            return $sale;
        });
    }

    /** Anula una compra válida (descuenta el stock) o reactiva una anulada (lo vuelve a sumar). */
    public function togglePurchase(Purchase $purchase): Purchase
    {
        return DB::transaction(function () use ($purchase) {
            $purchase = Purchase::whereKey($purchase->id)->lockForUpdate()->firstOrFail();
            $quantities = $this->quantitiesByProduct($purchase->purchaseDetails);
            $products = $this->lockProducts(array_keys($quantities));

            if ($purchase->isValid()) {
                foreach ($quantities as $productId => $quantity) {
                    if ($products[$productId]->stock < $quantity) {
                        $this->fail("No se puede anular la compra: parte de «{$products[$productId]->name}» ya se vendió (stock actual {$products[$productId]->stock}).");
                    }
                }
                foreach ($quantities as $productId => $quantity) {
                    $products[$productId]->decrement('stock', $quantity);
                }
                $purchase->update(['status' => Purchase::CANCELED]);
            } else {
                foreach ($quantities as $productId => $quantity) {
                    $products[$productId]->increment('stock', $quantity);
                }
                $purchase->update(['status' => Purchase::VALID]);
            }

            return $purchase;
        });
    }

    /** Une líneas repetidas del mismo producto (p. ej. escaneado dos veces). */
    private function groupItems(array $items, array $keep): array
    {
        $grouped = [];

        foreach ($items as $item) {
            $id = (int) $item['product_id'];
            $quantity = (int) $item['quantity'];

            if ($quantity <= 0) {
                continue;
            }
            if (isset($grouped[$id])) {
                $grouped[$id]['quantity'] += $quantity;
                continue;
            }

            $grouped[$id] = ['quantity' => $quantity];
            foreach ($keep as $key) {
                $grouped[$id][$key] = $item[$key] ?? 0;
            }
        }

        if (! $grouped) {
            $this->fail('Agregue al menos un producto.');
        }

        return $grouped;
    }

    private function lockProducts(array $ids)
    {
        $products = Product::whereIn('id', $ids)->orderBy('id')->lockForUpdate()->get()->keyBy('id');

        if ($products->count() !== count($ids)) {
            $this->fail('Uno de los productos ya no existe.');
        }

        return $products;
    }

    private function quantitiesByProduct($details): array
    {
        $quantities = [];
        foreach ($details as $detail) {
            $quantities[$detail->product_id] = ($quantities[$detail->product_id] ?? 0) + $detail->quantity;
        }

        return $quantities;
    }

    private function totalWithTax(float $subtotal, float $taxPercent): float
    {
        return round($subtotal + $subtotal * $taxPercent / 100, 2);
    }

    private function fail(string $message): void
    {
        throw ValidationException::withMessages(['products' => $message]);
    }
}
