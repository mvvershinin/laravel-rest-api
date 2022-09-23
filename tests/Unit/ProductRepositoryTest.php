<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Repositories\ProductRepository;
use PHPUnit\Framework\TestCase;
use Tests\CreatesApplication;
use Tests\Structures\ProductStructures;

class ProductRepositoryTest extends TestCase
{
    use CreatesApplication;

    /** @test */
    public function test_create()
    {
        $app = $this->createApplication();
        $data = ProductStructures::getProduct($app);

        $repository = new ProductRepository(new Product);
        $product = $repository->create($data);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals($data['title'], $product->title);
        $this->assertEquals($data['eid'], $product->eid);
        $this->assertEquals($data['price'], $product->price);
    }
}
