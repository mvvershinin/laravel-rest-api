<?php

namespace Tests\Structures;

use App\Models\Category;
use App\Models\Product;

class ProductStructures
{
    const CATEGORIES_COUNT = 3;

    const PRODUCT_KEYS = [
        'eid',
        'title',
        'price',
        'categories_ids',
    ];

    const PRODUCT = [
        'data' => [
            'id',
            'title',
            'external_id',
            'price',
            'created_at',
            'updated_at',
            'categories' => [
                '*' => [
                    'id',
                    'title',
                ],
            ],
        ],
    ];

    const PRODUCTS = [
        'data' => ['*' => ['id', 'title', 'price'],],
        'meta' => ['current_page', 'from', 'last_page',],
    ];

    const PRODUCTS_STORED = [
        'data' => ['id', 'title', 'price'],
        'message',
    ];

    const PRODUCT_ERROR = ['message', 'errors'];

    const PRODUCT_ERROR_VALUES = [
        'eid' => ['string', 0, -1],
        'title' => [123, 'abc'],
        'price' => ['string', 0, -1],
        'categories_ids' => ['not array', ['a', 'b', 'c']],
    ];

    public static function getProduct()
    {
        $categories = Category::factory()->create();

        return [
            'eid' => 123,
            'title' => 'test title',
            'price' => 123.45,
            'categories_ids' => $categories->pluck('id')->toArray(),
        ];
    }

    public static function getProductId()
    {
        $categories = Category::factory()->count(self::CATEGORIES_COUNT)->create();
        $product = Product::factory()->create();
        $product->categories()->attach($categories->pluck('id')->toArray());

        return $product->id;
    }
}
