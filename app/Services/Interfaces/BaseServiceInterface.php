<?php

namespace App\Services\Interfaces;

interface BaseServiceInterface
{
    /**
     * save new product to DB with categories
     *
     * @param array $input
     * @return mixed
     */
    public function store(array $input);

    /**
     * update product
     *
     * @param array $input
     * @param $id
     * @return mixed
     */
    public function update(array $input, $id);

    /**
     * delete product and relation with category
     *
     * @param $id
     * @return mixed
     */
    public function delete($id);
}
