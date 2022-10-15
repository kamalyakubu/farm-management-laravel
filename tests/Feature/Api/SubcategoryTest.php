<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Subcategory;

use App\Models\Category;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubcategoryTest extends TestCase
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
    public function it_gets_subcategories_list()
    {
        $subcategories = Subcategory::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.subcategories.index'));

        $response->assertOk()->assertSee($subcategories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_subcategory()
    {
        $data = Subcategory::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.subcategories.store'), $data);

        $this->assertDatabaseHas('subcategories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_subcategory()
    {
        $subcategory = Subcategory::factory()->create();

        $category = Category::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'category_id' => $category->id,
        ];

        $response = $this->putJson(
            route('api.subcategories.update', $subcategory),
            $data
        );

        $data['id'] = $subcategory->id;

        $this->assertDatabaseHas('subcategories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_subcategory()
    {
        $subcategory = Subcategory::factory()->create();

        $response = $this->deleteJson(
            route('api.subcategories.destroy', $subcategory)
        );

        $this->assertModelMissing($subcategory);

        $response->assertNoContent();
    }
}
