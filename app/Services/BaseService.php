<?php

namespace App\Services;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Facades\DB;

abstract class BaseService implements Interfaces\BaseServiceInterface
{
    protected BaseRepositoryInterface $repository;

    public function __construct(BaseRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(array $input)
    {
        DB::beginTransaction();
        try {
            $product = $this->repository->create($input);
            $this->storeRelations($product, $input);
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();

        return $product;
    }

    public function update(array $input, $id)
    {
        DB::beginTransaction();
        try {
            $product = $this->repository->find($id);
            $this->storeRelations($product, $input, 'syncRelation');
            $this->repository->update($input, ['id' => $id]);

            $product = $this->repository->getWithRelations($id);

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();

        return $product;
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $product = $this->repository->find($id);
            foreach ($this->repository->getRelations() as $relation) {
                $product->$relation()->detach();
            }
            $product->delete();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();
    }


    private function storeRelations(&$product, &$input, $method = 'attachRelation')
    {
        foreach ($input as $key => $value){
            if(preg_match('/.*?_ids/',$key)){
                $relation = preg_replace( '/_ids/', '', $key);
                $this->repository->$method($product, $input[$key], $relation);
                unset($input[$key]);
            }
        }
    }
}
