<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;


class ProductService extends BaseService implements Interfaces\ProductServiceInterface
{
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        parent::__construct($productRepository);
    }
}
