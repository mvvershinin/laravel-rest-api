<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\GetByIdRequest;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductCollectionResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Services\Interfaces\ProductServiceInterface;

class ProductController extends Controller
{
    protected $productRepository;

    protected $productService;

    public function __construct(
        ProductServiceInterface $productService,
        ProductRepositoryInterface $productRepository,

    ) {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollectionResource::collection(
            $this->productRepository->getPaginated()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Product\StoreRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return (new ProductCollectionResource(
            $this->productService->store($request->validated())
        ))->additional(['message' => __('notifications.store.success')])
            ->response()
            ->setStatusCode(\Illuminate\Http\Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Http\Requests\Product\GetByIdRequest $request
     * @return \App\Http\Resources\ProductResource|\Illuminate\Http\Response
     */
    public function show(GetByIdRequest $request)
    {
        return new ProductResource(
            $this->productRepository->getWithRelations($request->id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, int $product)
    {
        return (new ProductResource(
            $this->productService->update($request->validated(), $product)
        ))->additional(['message' => __('notifications.update.success')])
            ->response()
            ->setStatusCode(\Illuminate\Http\Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(GetByIdRequest $request)
    {
        $this->productService->delete($request->id);
        return response()
            ->json(['message' => trans('notifications.destroy.success'),])
            ->setStatusCode(\Illuminate\Http\Response::HTTP_ACCEPTED);
    }
}
