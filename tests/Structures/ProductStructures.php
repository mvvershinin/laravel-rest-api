<?php

namespace Tests\Structures;

class ProductStructures
{
    const PRODUCT = [
        'data' => [
            'id',
            'title',
            'external_id',
            'created_at',
            'updated_at',
            'categories' => [
                '*' => [
                    'id',
                    'title'
                ]
            ]
        ],
    ];

    const PRODUCTS = [
        'data' => [ '*' => [ 'id', 'title', ], ],
        'meta' => [ 'current_page', 'from', 'last_page', ],
    ];

    const PRODUCT_ERROR = [ 'message', 'errors'];
}
