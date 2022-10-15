<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Products;

use App\Models\Subcategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_all_products()
    {
        $allProducts = Products::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('all-products.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.all_products.index')
            ->assertViewHas('allProducts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_products()
    {
        $response = $this->get(route('all-products.create'));

        $response->assertOk()->assertViewIs('app.all_products.create');
    }

    /**
     * @test
     */
    public function it_stores_the_products()
    {
        $data = Products::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('all-products.store'), $data);

        $this->assertDatabaseHas('products', $data);

        $products = Products::latest('id')->first();

        $response->assertRedirect(route('all-products.edit', $products));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_products()
    {
        $products = Products::factory()->create();

        $response = $this->get(route('all-products.show', $products));

        $response
            ->assertOk()
            ->assertViewIs('app.all_products.show')
            ->assertViewHas('products');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_products()
    {
        $products = Products::factory()->create();

        $response = $this->get(route('all-products.edit', $products));

        $response
            ->assertOk()
            ->assertViewIs('app.all_products.edit')
            ->assertViewHas('products');
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

        $response = $this->put(route('all-products.update', $products), $data);

        $data['id'] = $products->id;

        $this->assertDatabaseHas('products', $data);

        $response->assertRedirect(route('all-products.edit', $products));
    }

    /**
     * @test
     */
    public function it_deletes_the_products()
    {
        $products = Products::factory()->create();

        $response = $this->delete(route('all-products.destroy', $products));

        $response->assertRedirect(route('all-products.index'));

        $this->assertModelMissing($products);
    }
}
