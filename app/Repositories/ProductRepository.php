<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository implements Interfaces\ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model, ['categories']);
    }
}
