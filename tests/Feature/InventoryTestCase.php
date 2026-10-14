<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Client;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

abstract class InventoryTestCase extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Client $client;
    protected Provider $provider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);

        $this->admin = User::where('email', 'admin@black.com')->firstOrFail();
        $this->client = Client::where('document', '222222222222')->firstOrFail();
        $this->provider = Provider::factory()->create();
    }

    protected function product(array $attributes = []): Product
    {
        return Product::factory()->create($attributes + [
            'provider_id' => $this->provider->id,
            'category_id' => Category::factory(),
        ]);
    }

    protected function cashier(): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Role::where('slug', 'cajero')->first());

        return $user;
    }
}
