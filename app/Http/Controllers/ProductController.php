<?php

namespace App\Http\Controllers;

use App\Http\Requests\Products\ShowRequest;
use App\Http\Resources\ProductCollectionResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Spatie\FlareClient\Http\Exceptions\NotFound;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        return ProductCollectionResource::collection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo __FUNCTION__;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \App\Http\Resources\ProductResource|\Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProductResource($this->srvShow($id));
    }

    public function srvShow($id)
    {
        try{
            return    Product::with(['categories'])->findOrFail($id);
        } catch (\Exception $e){
            if($e instanceof ModelNotFoundException){
                throw new HttpResponseException(response()->json(['error' => __('exception.not_found')], 404));
            }

            //todo logging implements
            throw new HttpResponseException(response()->json(['error' => __('error.internal_server_error')], 422));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        echo __FUNCTION__;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        echo __FUNCTION__;
    }
}
