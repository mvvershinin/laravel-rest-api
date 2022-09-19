<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    protected $relations = [];

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model, $relations = [])
    {
        $this->model = $model;
        $this->relations = $relations;
    }

    /**
     * @return false|string
     */
    public function getClassName()
    {
        return get_class($this->model);
    }

    /**
     * @return Model
     */
    public function getInstance()
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getKeyName()
    {
        return $this->model->getKeyName();
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->model->getTable();
    }

    /**
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function createMultiple(array $attributes)
    {
        return $this->model->insert($attributes);
    }

    /**
     * @param $id
     * @return Model
     */
    public function find($id): Model
    {
        return $this->model->find($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWithRelations($id)
    {
        return $this->model->with($this->relations)->findOrFail($id);
    }

    /**
     * @param $product
     * @param $relation
     * @param array $categories
     */
    public function attachRelation(&$product, string $relation, array $categories): void
    {
        $product->$relation()->attach($categories);
    }

    /**
     * @param $product
     * @param $relation
     * @param array $categories
     */
    public function syncRelation(&$product, string $relation, array $categories): void
    {
        $product->$relation()->sync($categories);
    }

    /**
     * @return mixed
     */
    public function getPaginated()
    {
        return $this->model->paginate();
    }

    /**
     * @param array $attributes
     * @param array $where
     * @return mixed
     */
    public function update(array $attributes, array $where = [])
    {
        return $this->model->where($where)->update($attributes);
    }

    /**
     * @param array $where
     * @param array $attributes
     * @return mixed
     */
    public function updateOrCreate(array $where, array $attributes)
    {
        return $this->model->updateOrCreate($where, $attributes);
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function delete(array $where)
    {
        return $this->model->where($where)->delete();
    }

    /**
     * @param array $where
     * @return mixed
     */
    public function exists(array $where)
    {
        return $this->model->where($where)->exists();
    }
}
