<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @param $id
     * @return mixed
     */
    public function getWithRelations($id);

    /**
     * @return mixed
     */
    public function getPaginated();

    /**
     * @param array $attributes
     * @param array $where
     * @return mixed
     */
    public function update(array $attributes, array $where = []);

    /**
     * @param array $where
     * @return mixed
     */
    public function delete(array $where);

    /**
     * @param array $where
     * @return mixed
     */
    public function exists(array $where);

    /**
     * @param array $where
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate(array $where, array $attributes);
}
