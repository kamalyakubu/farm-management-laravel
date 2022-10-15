<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Category;
use App\Models\Subcategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategorySubcategoriesTest extends TestCase
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
    public function it_gets_category_subcategories()
    {
        $category = Category::factory()->create();
        $subcategories = Subcategory::factory()
            ->count(2)
            ->create([
                'category_id' => $category->id,
            ]);

        $response = $this->getJson(
            route('api.categories.subcategories.index', $category)
        );

        $response->assertOk()->assertSee($subcategories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_category_subcategories()
    {
        $category = Category::factory()->create();
        $data = Subcategory::factory()
            ->make([
                'category_id' => $category->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.categories.subcategories.store', $category),
            $data
        );

        $this->assertDatabaseHas('subcategories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $subcategory = Subcategory::latest('id')->first();

        $this->assertEquals($category->id, $subcategory->category_id);
    }
}
