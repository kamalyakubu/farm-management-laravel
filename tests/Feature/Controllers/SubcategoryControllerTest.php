<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Subcategory;

use App\Models\Category;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubcategoryControllerTest extends TestCase
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
    public function it_displays_index_view_with_subcategories()
    {
        $subcategories = Subcategory::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('subcategories.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.subcategories.index')
            ->assertViewHas('subcategories');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_subcategory()
    {
        $response = $this->get(route('subcategories.create'));

        $response->assertOk()->assertViewIs('app.subcategories.create');
    }

    /**
     * @test
     */
    public function it_stores_the_subcategory()
    {
        $data = Subcategory::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('subcategories.store'), $data);

        $this->assertDatabaseHas('subcategories', $data);

        $subcategory = Subcategory::latest('id')->first();

        $response->assertRedirect(route('subcategories.edit', $subcategory));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_subcategory()
    {
        $subcategory = Subcategory::factory()->create();

        $response = $this->get(route('subcategories.show', $subcategory));

        $response
            ->assertOk()
            ->assertViewIs('app.subcategories.show')
            ->assertViewHas('subcategory');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_subcategory()
    {
        $subcategory = Subcategory::factory()->create();

        $response = $this->get(route('subcategories.edit', $subcategory));

        $response
            ->assertOk()
            ->assertViewIs('app.subcategories.edit')
            ->assertViewHas('subcategory');
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

        $response = $this->put(
            route('subcategories.update', $subcategory),
            $data
        );

        $data['id'] = $subcategory->id;

        $this->assertDatabaseHas('subcategories', $data);

        $response->assertRedirect(route('subcategories.edit', $subcategory));
    }

    /**
     * @test
     */
    public function it_deletes_the_subcategory()
    {
        $subcategory = Subcategory::factory()->create();

        $response = $this->delete(route('subcategories.destroy', $subcategory));

        $response->assertRedirect(route('subcategories.index'));

        $this->assertModelMissing($subcategory);
    }
}
