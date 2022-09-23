<?php

namespace Tests\Structures;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Tests\CreatesApplication;

class ProductStructures
{
    use CreatesApplication;

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

    public static function getProduct(&$app)
    {
        $categoryRepository = $app->make(CategoryRepository::class);
        $categories = $categoryRepository->getInstance()::factory()->create();

        return [
            'eid' => 123,
            'title' => 'test title',
            'price' => 123.45,
            'categories_ids' => $categories->pluck('id')->toArray(),
        ];
    }

    public static function getProductId()
    {
        $categoryRepository = \App::make(CategoryRepository::class);
        $categories = $categoryRepository->getInstance()::factory()->count(self::CATEGORIES_COUNT)->create();

        $productRepository = \App::make(ProductRepository::class);
        $product = $productRepository->getInstance()::factory()->create();

        $product->categories()->attach($categories->pluck('id')->toArray());

        return $product->id;
    }
}
