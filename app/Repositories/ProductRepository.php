<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository implements Interfaces\ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model, ['categories']);
    }

    public function attachCategories(&$product, array $categories)
    {
        $product->categories()->attach($categories);
        return $product->save();
    }

    public function syncCategories(&$product, array $categories)
    {
        $product->categories()->sync($categories);
    }
}
