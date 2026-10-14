<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\Category;
use App\Models\Permission;
use App\Models\Printer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\Sale;
use App\Models\User;
use App\Services\InventoryService;
use App\Services\TicketPrinter;
use Illuminate\Support\Facades\Hash;
use Mike42\Escpos\PrintConnectors\PrintConnector;

class PagesTest extends InventoryTestCase
{
    private Sale $sale;
    private Purchase $purchase;

    protected function setUp(): void
    {
        parent::setUp();

        $product = $this->product(['stock' => 0, 'sell_price' => 12500]);
        $inventory = app(InventoryService::class);
        $this->purchase = $inventory->registerPurchase($this->provider->id, $this->admin->id, 0, [
            ['product_id' => $product->id, 'quantity' => 20, 'price' => 9000],
        ]);
        // 2 x 12.500 - 5% = 23.750 + 19% IVA = 28.262,5
        $this->sale = $inventory->registerSale($this->client->id, $this->admin->id, 19, [
            ['product_id' => $product->id, 'quantity' => 2, 'discount' => 5],
        ]);
    }

    public function test_guests_are_sent_to_login(): void
    {
        foreach (['/home', '/sales', '/products', '/users', '/reports/day'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
        $this->get('/login')->assertOk();
        $this->get('/register')->assertNotFound();
    }

    public function test_every_page_loads_for_the_admin(): void
    {
        $product = $this->sale->saleDetails()->first()->product;
        $role = Role::where('slug', 'cajero')->first();

        $urls = [
            route('home'), route('profile.edit'),
            route('users.index'), route('users.create'), route('users.show', $this->admin), route('users.edit', $this->admin),
            route('roles.index'), route('roles.create'), route('roles.show', $role), route('roles.edit', $role),
            route('business.index'), route('printer.index'),
            route('categories.index'), route('categories.create'), route('categories.edit', $product->category),
            route('clients.index'), route('clients.create'), route('clients.show', $this->client), route('clients.edit', $this->client),
            route('providers.index'), route('providers.create'), route('providers.show', $this->provider), route('providers.edit', $this->provider),
            route('products.index'), route('products.index', ['low' => 1, 'q' => 'a']), route('products.create'),
            route('products.show', $product), route('products.edit', $product),
            route('purchases.index'), route('purchases.create'), route('purchases.show', $this->purchase),
            route('sales.index'), route('sales.index', ['q' => 'CONSUMIDOR']), route('sales.create'), route('sales.show', $this->sale),
            route('reports.day'), route('reports.date'),
            route('reports.date', ['fecha_ini' => '2020-01-01', 'fecha_fin' => now()->toDateString()]),
        ];

        $this->actingAs($this->admin);
        foreach ($urls as $url) {
            $this->get($url)->assertOk();
        }

        $this->get(route('home'))->assertSee('$ 28.262,5', false);
        $this->get(route('reports.day'))->assertSee($product->name);
        $this->get(route('sales.show', $this->sale))->assertSee('$ 23.750', false);
    }

    public function test_pdfs_are_generated(): void
    {
        $this->actingAs($this->admin);
        $this->get(route('sales.pdf', $this->sale))->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->get(route('purchases.pdf', $this->purchase))->assertOk()->assertHeader('content-type', 'application/pdf');
    }

    public function test_ticket_contains_the_sale(): void
    {
        $connector = new class implements PrintConnector {
            public string $data = '';
            public function __destruct() {}
            public function finalize() {}
            public function read($len) { return false; }
            public function write($data) { $this->data .= $data; }
        };

        $printer = new TicketPrinter();
        $printer->connector = $connector;
        $printer->printSale($this->sale);

        $this->assertStringContainsString('Venta N.', $connector->data);
        $this->assertStringContainsString('CONSUMIDOR FINAL', $connector->data);
        $this->assertStringContainsString('$28.263', $connector->data); // total redondeado a pesos
        $this->assertStringContainsString('-5%', $connector->data);
        $this->assertStringContainsString('Impuesto (19%)', $connector->data);
    }

    public function test_printing_failure_shows_a_message_instead_of_an_error_page(): void
    {
        Printer::current()->update(['connector' => 'network', 'host' => '127.0.0.1', 'port' => 9]);

        $this->actingAs($this->admin)
            ->from(route('sales.show', $this->sale))
            ->post(route('sales.print', $this->sale))
            ->assertRedirect(route('sales.show', $this->sale))
            ->assertSessionHas('error');
    }

    public function test_cashier_only_sees_what_the_role_allows(): void
    {
        $this->actingAs($this->cashier());

        $this->get(route('sales.create'))->assertOk();
        $this->get(route('home'))->assertOk()->assertSee('NUEVA VENTA')->assertDontSee('USUARIOS');
        $this->get(route('users.index'))->assertForbidden();
        $this->get(route('purchases.index'))->assertForbidden();
        $this->patch(route('change.status.sales', $this->sale))->assertForbidden();
        $this->getJson(route('products.lookup', ['q' => 'a']))->assertOk();
    }

    public function test_user_without_role_cannot_do_anything(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('home'))->assertOk();
        $this->get(route('sales.index'))->assertForbidden();
        $this->getJson(route('products.lookup', ['q' => 'a']))->assertForbidden();
    }

    public function test_admin_manages_users_and_roles(): void
    {
        $this->actingAs($this->admin);
        $cashierRole = Role::where('slug', 'cajero')->first();

        $this->post(route('users.store'), [
            'name' => 'Ana Caja',
            'email' => 'ana@tienda.co',
            'password' => 'secreto1',
            'password_confirmation' => 'secreto1',
            'roles' => [$cashierRole->id],
        ])->assertRedirect(route('users.index'))->assertSessionHasNoErrors();

        $ana = User::where('email', 'ana@tienda.co')->firstOrFail();
        $this->assertTrue(Hash::check('secreto1', $ana->password));
        $this->assertTrue($ana->can('sales.create'));
        $this->assertFalse($ana->can('users.index'));

        $this->post(route('roles.store'), [
            'name' => 'Bodega',
            'permissions' => Permission::whereIn('slug', ['purchases.index', 'purchases.create'])->pluck('id')->all(),
        ])->assertSessionHasNoErrors();
        $this->assertSame(2, Role::where('slug', 'bodega')->first()->permissions()->count());

        $this->delete(route('users.destroy', $this->admin))->assertSessionHas('error');
    }

    public function test_business_printer_and_product_forms_save(): void
    {
        $this->actingAs($this->admin);

        $this->put(route('business.update'), ['name' => 'Tienda Don Jofre', 'nit' => '123-4'])->assertSessionHasNoErrors();
        $this->assertSame('Tienda Don Jofre', Business::current()->name);

        $this->put(route('printer.update'), ['connector' => 'network', 'host' => '192.168.1.50', 'width' => 32])->assertSessionHasNoErrors();
        $this->assertSame('192.168.1.50', Printer::current()->host);

        $category = Category::factory()->create();
        $this->post(route('products.store'), [
            'name' => 'Panela', 'sell_price' => 3200, 'category_id' => $category->id, 'provider_id' => $this->provider->id,
        ])->assertSessionHasNoErrors();
        $panela = Product::where('name', 'Panela')->firstOrFail();
        $this->assertSame((string) $panela->id, $panela->code);

        $this->put(route('products.update', $panela), [
            'name' => 'Panela 500 g', 'code' => '7701', 'sell_price' => 3300, 'category_id' => $category->id, 'provider_id' => $this->provider->id,
        ])->assertSessionHasNoErrors();
        $this->assertSame('7701', $panela->fresh()->code);

        $this->patch(route('change.status.products', $panela));
        $this->assertSame('DEACTIVATE', $panela->fresh()->status);
        $this->patch(route('change.status.products', $panela));
        $this->assertSame('ACTIVE', $panela->fresh()->status);

        $this->delete(route('categories.destroy', $category))->assertSessionHas('error'); // tiene productos
    }
}
