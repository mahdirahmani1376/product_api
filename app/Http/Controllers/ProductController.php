<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use App\Repositories\ProductInterface;
use App\Repositories\ProductRepository;
use App\Utilities\CustomResponse;

class ProductController extends Controller
{

    public ProductRepository $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductInterface $productRepository)
    {

        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return CustomResponse::resource($this->productRepository->index(),'product fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreproductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreproductRequest $request)
    {
        return CustomResponse::resource($this->productRepository->store($request),'product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return CustomResponse::resource($this->productRepository->show($product),'product fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateproductRequest  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateproductRequest $request, Product $product)
    {

        return CustomResponse::resource($this->productRepository->update($request,$product),'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        return CustomResponse::resource($this->productRepository->destroy($product),'product deleted successfully');
    }

}

