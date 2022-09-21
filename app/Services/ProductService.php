<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductService implements Interfaces\ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function store(array $input)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->create($input);
            if (isset($input['categories_ids'])) {
                $this->productRepository->attachRelation($product, 'categories', $input['categories_ids']);
            }
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
            if (isset($input['categories_ids'])){
                $product = $this->productRepository->find($id);
                $this->productRepository->syncRelation(
                    $product,
                    'categories',
                    $input['categories_ids']
                );
                unset($input['categories_ids']);
            }

            $this->productRepository->update(
                $input,
                ['id' => $id]
            );

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
            $product->categories()->detach();
            $product->delete();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
        DB::commit();

    }

}
