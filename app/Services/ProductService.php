<?php

namespace App\Services;

use App\Dto\ProductDto;
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
            $this->productRepository->attachCategories($product, $input['categories_ids']);
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
            $this->productRepository->update(
                (array)ProductDto::get($input),
                ['id' => $id]
            );
            if (isset($input['categories_ids'])){
                $product = $this->productRepository->find($id);
                $this->productRepository->syncCategories(
                    $product,
                    $input['categories_ids']
                );
            }

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
