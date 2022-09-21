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

use function Sodium\randombytes_random16;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    const API = '/api';

    public function test_products_get_list()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $this->withHeaders(['Accept' => 'application/json'])->get(self::API.'/products')
            ->assertJsonStructure(ProductStructures::PRODUCTS)
            ->assertStatus(200);
    }

    public function test_product_get_by_id()
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->get(self::API.'/products/'. ProductStructures::getProductId())
            ->assertJsonStructure(ProductStructures::PRODUCT)
            ->assertStatus(200);
    }

    public function test_product_get_by_id_fail()
    {
        $this->withHeaders(['Accept' => 'application/json'])->get(self::API.'/products/1a')
            ->assertJsonStructure(ProductStructures::PRODUCT_ERROR)
            ->assertStatus(422);
    }

    public function test_product_create()
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->post(self::API.'/products', ProductStructures::getProduct())
            ->assertJsonStructure(ProductStructures::PRODUCTS_STORED)
            ->assertStatus(201);
    }

    public function test_product_create_fail_required_values()
    {
        foreach (ProductStructures::PRODUCT_KEYS as $key){
            $invalid_product = ProductStructures::getProduct();
            unset($invalid_product[$key]);

            $this->withHeaders(['Accept' => 'application/json'])
                ->post(self::API.'/products', $invalid_product)
                ->assertJsonStructure(ProductStructures::PRODUCT_ERROR)
                ->assertStatus(422);
        }
    }

    public function test_product_create_fail_validation()
    {
        foreach (ProductStructures::PRODUCT_ERROR_VALUES as $key => $values){
            foreach ($values as $value){
            $invalid_product = ProductStructures::getProduct();

            $invalid_product[$key] = $value;

            $r = $this->withHeaders(['Accept' => 'application/json'])
                ->post(self::API.'/products', $invalid_product);

                $r->assertJsonStructure(ProductStructures::PRODUCT_ERROR)
                ->assertStatus(422);

        }
        }
    }
}
