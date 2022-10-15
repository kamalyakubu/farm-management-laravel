<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Products;
use App\Models\Subcategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubcategoryAllProductsTest extends TestCase
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
    public function it_gets_subcategory_all_products()
    {
        $subcategory = Subcategory::factory()->create();
        $allProducts = Products::factory()
            ->count(2)
            ->create([
                'subcategory_id' => $subcategory->id,
            ]);

        $response = $this->getJson(
            route('api.subcategories.all-products.index', $subcategory)
        );

        $response->assertOk()->assertSee($allProducts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_subcategory_all_products()
    {
        $subcategory = Subcategory::factory()->create();
        $data = Products::factory()
            ->make([
                'subcategory_id' => $subcategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.subcategories.all-products.store', $subcategory),
            $data
        );

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $products = Products::latest('id')->first();

        $this->assertEquals($subcategory->id, $products->subcategory_id);
    }
}
