<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductService implements Interfaces\ProductServiceInterface
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function store(array $input)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->create($input);
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
            $product = $this->productRepository->find($id);
            $this->storeRelations($product, $input, 'syncRelation');
            $this->productRepository->update($input, ['id' => $id]);

            $product = $this->productRepository->getWithRelations($id);

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
            $product = $this->productRepository->find($id);
            foreach ($this->productRepository->getRelations() as $relation) {
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
                $this->productRepository->$method($product, $input[$key], $relation);
                unset($input[$key]);
            }
        }
    }
}
