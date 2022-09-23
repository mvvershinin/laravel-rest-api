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
     * @return array
     */
    public function getRelations();

    /**
     * @param $id
     * @param $relations
     */
    public function getWithRelations($id, array $relations = null);

    /**
     * @param $product
     * @param $relation
     * @param array $relation_ids
     */
    public function attachRelation(&$product, array $relation_ids, $relation = null);


    /**
     * @param $product
     * @param $relation
     * @param array $relation_ids
     */
    public function syncRelation(&$product, array $relation_ids, $relation = null);

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
