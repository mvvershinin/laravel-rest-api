<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * append to exists list of categories
     *
     * @param $product
     * @param array $categories
     * @return mixed
     */
    public function attachCategories(&$product, array $categories);

    /**
     * add modified catigories list,
     * it will delete all exists categories
     *
     * @param $product
     * @param array $categories
     * @return mixed
     */
    public function syncCategories(&$product, array $categories);
}
