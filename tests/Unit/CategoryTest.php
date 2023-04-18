<?php
namespace Tests\Unit;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category\Category;
use App\Models\User;
use Faker\Factory;
use JustSteveKing\StatusCode\Http;

class CategoryTest extends \Tests\TestCase
{
    private const BASE_URL = 'api/categories';

    public function test_list_no_categories(): void
    {
        $response = $this
            ->actingAs(User::factory()->create())
            ->get(self::BASE_URL);
        $response->assertNoContent();
    }

    public function test_create_category() : void
    {
        $this->withoutExceptionHandling();
        $response = $this
            ->actingAs(User::factory()->create())
            ->postJson(self::BASE_URL, ['name' => Factory::create()->name(), 'slug' => Factory::create()->slug()]);
        $response->assertCreated();
    }

    public function test_list_all_categories(): void
    {
        $response = $this
            ->actingAs(User::factory()->create()->first())
            ->get(self::BASE_URL);
        $response->assertStatus(Http::OK());
    }

    public function test_show_category() : void
    {
        $category = Category::factory(count: 1)->create()->first();
        $response = $this->actingAs(User::factory(count: 1)->create()->first())
            ->getJson(self::BASE_URL.'/'.$category->id);
        $response->assertOk();
    }

    public function test_update_category() : void {
        $category = Category::factory(count : 1)->create()->first();
        $response = $this
            ->actingAs(User::factory()->create()->first())
            ->putJson(self::BASE_URL . '/' . $category->id, [
            'name' => Factory::create()->name(),
            'slug' => Factory::create()->slug(),
        ]);
        $response->assertOk();
        $this->assertModelExists($category);
    }

    public function test_destroy_category() : void {
        $this->withoutExceptionHandling();
        $category = Category::factory(count: 1)->create()->first();
        $response = $this
            ->actingAs(User::factory()->create()->first())
            ->deleteJson(self::BASE_URL . '/' . $category->id);
        $response->assertOk();
        $this->assertSoftDeleted($category);
    }

    /** TESTES DAS SUBCATEGORIAS */

    public function test_doesnt_have_children() : void
    {
        $this->withoutExceptionHandling();
        $category = Category::factory(count: 1)->create()->first();
        $this->assertEmpty($category->children()->get());
    }

    public function test_doesnt_have_parent() : void
    {
        $this->withoutExceptionHandling();
        $subCategory = Category::factory(count: 1)->create()->first();
        $this->assertNull($subCategory->parent()->first());
    }

    public function test_have_children() : void
    {
        $this->withoutExceptionHandling();
        $category = Category::factory(count: 1)->create()->first();
        Category::factory(count: 3)->create(['parent_id' => $category->id]);
        $this->assertTrue($category->children()->exists());
    }

    public function test_have_parent() : void
    {
        $this->withoutExceptionHandling();
        $category = Category::factory(count: 1)->create()->first();
        $subCategory = Category::factory(count: 3)->create(['parent_id' => $category->id]);
        $this->assertTrue($subCategory->where('parent_id', $category->id)->count() > 0);
    }
}
