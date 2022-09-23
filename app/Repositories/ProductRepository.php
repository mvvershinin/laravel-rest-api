<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository implements Interfaces\ProductRepositoryInterface
{
    const DEFAULT_RELATION = 'categories';

    const RELATION_KEYS = [
        'categories' => 'categories_ids',
    ];

    public function __construct(Product $model)
    {
        parent::__construct($model, [self::DEFAULT_RELATION]);
    }

    public function getDefaultRelation(): string
    {
        return self::DEFAULT_RELATION;
    }
}
