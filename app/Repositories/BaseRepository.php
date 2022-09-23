<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Interfaces\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    protected array $relations = [];

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     * @param array $relations
     */
    public function __construct(Model $model, $relations)
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
     * @return mixed
     */
    abstract public function getDefaultRelation();

    /**
     * @return array
     */
    public function getRelations(): array
    {
        return $this->relations;
    }

    /**
     * @param $id
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getWithRelations($id, array $relations = null)
    {
        return $this->model
            ->with($relations ?: $this->getRelations())
            ->findOrFail($id);
    }

    /**
     * @param $product
     * @param $relation
     * @param array $relation_ids
     */
    public function attachRelation(&$product, array $relation_ids, $relation = null): void
    {
        $relation = $relation ?: $this->getDefaultRelation();
        $product->$relation()->attach($relation_ids);
    }

    /**
     * @param $product
     * @param $relation
     * @param array $relation_ids
     */
    public function syncRelation(&$product, array $relation_ids, $relation = null): void
    {
        $relation = $relation ?: $this->getDefaultRelation();
        $product->$relation()->sync($relation_ids);
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
