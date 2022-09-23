<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository implements Interfaces\CategoryRepositoryInterface
{
    const DEFAULT_RELATION = 'products';

    public function __construct(Category $model)
    {
        parent::__construct($model, [self::DEFAULT_RELATION]);
    }

    public function getDefaultRelation()
    {
        return self::DEFAULT_RELATION;
    }
}
