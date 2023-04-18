<?php

namespace Tests\Unit;

use App\Models\Category\Category;
use App\Models\Image;
use App\Models\Product\Product;
use App\Models\User;
use Faker\Factory;

class ProductTest extends \Tests\TestCase
{
    private const BASE_URL = 'api/products';

    public function test_no_list_products() : void
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory(count: 1)->create()->first())
            ->getJson(self::BASE_URL)
            ->assertNoContent();
    }

    public function test_list_all_without_parameters() : void
    {
        $this->withoutExceptionHandling();
        $user = User::factory(count: 1)->create()->first();
        Product::factory(count: 2)
            ->has(Category::factory(count: 1), 'category')
            ->create(['user_id' => $user->id]);
        $this->actingAs($user)
            ->getJson(self::BASE_URL)
            ->assertOk();
    }

    public function test_create_product() : void
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::factory()->create())
            ->postJson(self::BASE_URL, [
                'name' => Factory::create()->name(),
                'slug' => Factory::create()->slug(),
                'description' => Factory::create()->text(),
                'price' => Factory::create()->randomFloat(2),
                'categories' => Category::factory(count: 2)->create()->map(fn ($values) => $values->id)->toArray(),
            ])
            ->assertCreated();
    }
}
