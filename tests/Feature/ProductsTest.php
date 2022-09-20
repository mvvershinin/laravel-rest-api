<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Factories\ProductFactory;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Structures\ProductStructures;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    const CATEGORIES_COUNT = 3;

    const API = '/api';

    public function test_products_get_list()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $response = $this->withHeaders(['Accept' => 'application/json'])->get(self::API.'/products');

        $response
            ->assertJsonStructure(ProductStructures::PRODUCTS)
            ->assertStatus(200);
    }

    public function test_products_get_by_id()
    {
        $categories = Category::factory()->count(self::CATEGORIES_COUNT)->create();
        $p = Product::factory()->create();
        $p->categories()->attach($categories->pluck('id')->toArray());


        $response = $this->withHeaders(['Accept' => 'application/json'])->get(self::API.'/products/'.$p->id);

        $response
            ->assertJsonStructure(ProductStructures::PRODUCT)
            ->assertStatus(200);
    }

    public function test_products_get_by_id_fail()
    {
        $response = $this->withHeaders(['Accept' => 'application/json'])->get(self::API.'/products/1a');

        $response
            ->assertJsonStructure(ProductStructures::PRODUCT_ERROR)
            ->assertStatus(422);
    }
}
