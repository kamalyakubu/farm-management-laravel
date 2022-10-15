<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Products;

use App\Models\Subcategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_all_products_list()
    {
        $allProducts = Products::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.all-products.index'));

        $response->assertOk()->assertSee($allProducts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_products()
    {
        $data = Products::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.all-products.store'), $data);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_products()
    {
        $products = Products::factory()->create();

        $subcategory = Subcategory::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'subcategory_id' => $subcategory->id,
        ];

        $response = $this->putJson(
            route('api.all-products.update', $products),
            $data
        );

        $data['id'] = $products->id;

        $this->assertDatabaseHas('products', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_products()
    {
        $products = Products::factory()->create();

        $response = $this->deleteJson(
            route('api.all-products.destroy', $products)
        );

        $this->assertModelMissing($products);

        $response->assertNoContent();
    }
}
