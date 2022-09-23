<?php

namespace Tests\Feature;

use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;
use Tests\Structures\ProductStructures;
use Tests\TestCase;


class ProductsTest extends TestCase
{
    use RefreshDatabase, CreatesApplication;

    const API = '/api';

    /** @test */
    public function test_get_list()
    {
        $this->seed(CategorySeeder::class);
        $this->seed(ProductSeeder::class);

        $this->withHeaders(['Accept' => 'application/json'])->get(self::API.'/products')->assertJsonStructure(
                ProductStructures::PRODUCTS
            )->assertStatus(200);
    }

    /** @test */
    public function test_get_by_id()
    {
        $this->withHeaders(['Accept' => 'application/json'])->get(
                self::API.'/products/'.ProductStructures::getProductId()
            )->assertJsonStructure(ProductStructures::PRODUCT)->assertStatus(200);
    }

    /** @test */
    public function test_get_by_id_fail()
    {
        $this->withHeaders(['Accept' => 'application/json'])->get(self::API.'/products/1a')->assertJsonStructure(
                ProductStructures::PRODUCT_ERROR
            )->assertStatus(422);
    }

    /** @test */
    public function test_create()
    {
        $app = $this->CreateApplication();
        $this->withHeaders(['Accept' => 'application/json'])->post(
                self::API.'/products',
                ProductStructures::getProduct($app)
            )->assertJsonStructure(ProductStructures::PRODUCTS_STORED)->assertStatus(201);
    }

    /** @test */
    public function test_create_fail_required_values()
    {
        $app = $this->CreateApplication();
        foreach (ProductStructures::PRODUCT_KEYS as $key) {
            $invalid_product = ProductStructures::getProduct($app);
            unset($invalid_product[$key]);

            $this->withHeaders(['Accept' => 'application/json'])->post(
                    self::API.'/products',
                    $invalid_product
                )->assertJsonStructure(ProductStructures::PRODUCT_ERROR)->assertStatus(422);
        }
    }

    /** @test */
    public function test_create_fail_validation()
    {
        $app = $this->CreateApplication();
        foreach (ProductStructures::PRODUCT_ERROR_VALUES as $key => $values) {
            foreach ($values as $value) {
                $invalid_product = ProductStructures::getProduct($app);

                $invalid_product[$key] = $value;

                $r = $this->withHeaders(['Accept' => 'application/json'])->post(
                        self::API.'/products',
                        $invalid_product
                    );

                $r->assertJsonStructure(ProductStructures::PRODUCT_ERROR)->assertStatus(422);
            }
        }
    }

    /** @test */
    public function test_delete_by_id()
    {
        $this->withHeaders(['Accept' => 'application/json'])->delete(
                self::API.'/products/'.ProductStructures::getProductId()
            )->assertJsonStructure(['message'])->assertStatus(202);
    }

    /** @test */
    public function test_delete_by_id_fail()
    {
        $this->withHeaders(['Accept' => 'application/json'])->delete(
            self::API.'/products/abc'
        )->assertJsonStructure(ProductStructures::PRODUCT_ERROR)->assertStatus(422);
    }
}
