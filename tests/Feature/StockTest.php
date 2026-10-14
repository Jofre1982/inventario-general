<?php

namespace Tests\Feature;

use App\Models\Purchase;
use App\Models\Sale;

class StockTest extends InventoryTestCase
{
    public function test_purchase_adds_stock_and_computes_total_on_server(): void
    {
        $rice = $this->product(['stock' => 0]);
        $oil = $this->product(['stock' => 3]);

        $this->actingAs($this->admin)->post(route('purchases.store'), [
            'provider_id' => $this->provider->id,
            'tax' => 19,
            'total' => 1, // el total del navegador se ignora
            'items' => [
                ['product_id' => $rice->id, 'quantity' => 10, 'price' => 3000],
                ['product_id' => $oil->id, 'quantity' => 5, 'price' => 9000],
            ],
        ])->assertRedirect()->assertSessionHasNoErrors();

        $this->assertSame(10, $rice->fresh()->stock);
        $this->assertSame(8, $oil->fresh()->stock);

        $purchase = Purchase::firstOrFail();
        $this->assertEquals(round((30000 + 45000) * 1.19, 2), $purchase->total);
        $this->assertSame($this->admin->id, $purchase->user_id);
    }

    public function test_sale_discounts_stock_using_database_prices_and_discounts(): void
    {
        $rice = $this->product(['stock' => 10, 'sell_price' => 4800]);

        $this->actingAs($this->admin)->post(route('sales.store'), [
            'client_id' => $this->client->id,
            'tax' => 0,
            'items' => [
                ['product_id' => $rice->id, 'quantity' => 2, 'discount' => 10, 'price' => 1], // precio manipulado: se ignora
                ['product_id' => $rice->id, 'quantity' => 1, 'discount' => 10], // escaneado dos veces: se une
            ],
        ])->assertRedirect()->assertSessionHasNoErrors();

        $this->assertSame(7, $rice->fresh()->stock);

        $sale = Sale::with('saleDetails')->firstOrFail();
        $this->assertCount(1, $sale->saleDetails);
        $this->assertEquals(4800, $sale->saleDetails[0]->price);
        $this->assertEquals(3 * 4800 * 0.9, $sale->total);
    }

    public function test_sale_is_rejected_when_stock_is_not_enough(): void
    {
        $rice = $this->product(['stock' => 2]);

        $this->actingAs($this->admin)->from(route('sales.create'))->post(route('sales.store'), [
            'client_id' => $this->client->id,
            'items' => [['product_id' => $rice->id, 'quantity' => 3, 'discount' => 0]],
        ])->assertRedirect(route('sales.create'))->assertSessionHasErrors('products');

        $this->assertSame(2, $rice->fresh()->stock);
        $this->assertSame(0, Sale::count());
    }

    public function test_a_failed_line_does_not_leave_a_half_saved_sale(): void
    {
        $ok = $this->product(['stock' => 10]);
        $short = $this->product(['stock' => 1]);

        $this->actingAs($this->admin)->post(route('sales.store'), [
            'client_id' => $this->client->id,
            'items' => [
                ['product_id' => $ok->id, 'quantity' => 4],
                ['product_id' => $short->id, 'quantity' => 5],
            ],
        ])->assertSessionHasErrors('products');

        $this->assertSame(10, $ok->fresh()->stock);
        $this->assertSame(0, Sale::count());
    }

    public function test_inactive_products_cannot_be_sold(): void
    {
        $product = $this->product(['stock' => 10, 'status' => 'DEACTIVATE']);

        $this->actingAs($this->admin)->post(route('sales.store'), [
            'client_id' => $this->client->id,
            'items' => [['product_id' => $product->id, 'quantity' => 1]],
        ])->assertSessionHasErrors('products');
    }

    public function test_canceling_a_sale_returns_stock_and_reactivating_takes_it_again(): void
    {
        $product = $this->product(['stock' => 5]);
        $this->actingAs($this->admin)->post(route('sales.store'), [
            'client_id' => $this->client->id,
            'items' => [['product_id' => $product->id, 'quantity' => 4]],
        ]);
        $sale = Sale::firstOrFail();
        $this->assertSame(1, $product->fresh()->stock);

        $this->patch(route('change.status.sales', $sale))->assertSessionHasNoErrors();
        $this->assertSame(Sale::CANCELED, $sale->fresh()->status);
        $this->assertSame(5, $product->fresh()->stock);

        $this->patch(route('change.status.sales', $sale))->assertSessionHasNoErrors();
        $this->assertSame(Sale::VALID, $sale->fresh()->status);
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_canceled_sale_cannot_be_reactivated_without_stock(): void
    {
        $product = $this->product(['stock' => 4]);
        $this->actingAs($this->admin)->post(route('sales.store'), [
            'client_id' => $this->client->id,
            'items' => [['product_id' => $product->id, 'quantity' => 4]],
        ]);
        $first = Sale::firstOrFail();
        $this->patch(route('change.status.sales', $first)); // anulada: stock vuelve a 4
        $this->post(route('sales.store'), [
            'client_id' => $this->client->id,
            'items' => [['product_id' => $product->id, 'quantity' => 3]],
        ]); // stock 1

        $this->patch(route('change.status.sales', $first))->assertSessionHasErrors('products');
        $this->assertSame(Sale::CANCELED, $first->fresh()->status);
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_canceling_a_purchase_removes_its_stock_unless_it_was_already_sold(): void
    {
        $product = $this->product(['stock' => 0]);
        $this->actingAs($this->admin)->post(route('purchases.store'), [
            'provider_id' => $this->provider->id,
            'items' => [['product_id' => $product->id, 'quantity' => 10, 'price' => 1000]],
        ]);
        $purchase = Purchase::firstOrFail();

        $this->post(route('sales.store'), [
            'client_id' => $this->client->id,
            'items' => [['product_id' => $product->id, 'quantity' => 6]],
        ]);
        $this->patch(route('change.status.purchases', $purchase))->assertSessionHasErrors('products');
        $this->assertSame(4, $product->fresh()->stock);

        // Si se anula la venta, la compra ya se puede anular.
        $this->patch(route('change.status.sales', Sale::firstOrFail()));
        $this->patch(route('change.status.purchases', $purchase))->assertSessionHasNoErrors();
        $this->assertSame(0, $product->fresh()->stock);
        $this->assertSame(Purchase::CANCELED, $purchase->fresh()->status);
    }

    public function test_product_lookup_finds_by_barcode_or_name(): void
    {
        $this->product(['name' => 'Arroz Diana 1 kg', 'code' => '7702001000011']);
        $this->product(['name' => 'Arroz Roa 500 g', 'code' => '7702001000099']);

        $this->actingAs($this->admin)->getJson(route('products.lookup', ['q' => '7702001000011']))
            ->assertOk()->assertJsonCount(1)->assertJsonPath('0.name', 'Arroz Diana 1 kg');

        $this->getJson(route('products.lookup', ['q' => 'arroz']))->assertOk()->assertJsonCount(2);
    }
}
