<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\LanguageProduct;
use App\Models\Product;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use App\Repositories\ProductInterface;
use App\Repositories\ProductRepository;
use App\Utilities\CustomResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $products = $this->productRepository->paginate();
        return CustomResponse::resource(ProductResource::collection($products),'product fetched successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreproductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreproductRequest $request)
    {
        $validated = $request->validated();

        if($file = $request->file('image_url')){
            $ImageName = time().$file->getClientOriginalName();
            Storage::disk('local')->putFileAs('images',$file,$ImageName);
            $validated['image_url'] = $ImageName;
        }

        $brand = Brand::where('name',$request['brand'])->first()->id;
        $category = Category::where('name',$request['category'])->first()->id;

        $product = $this->productRepository->create($validated,$brand,$category);

        $product_id = $product->id;

        $data = $request->data;
        foreach ($data as $language) {
            LanguageProduct::create([
                'language_id' => $language['language_id'],
                'product_id' => $product_id,
                'iso_code' => Language::find($language['language_id'])->iso_code,
                'model' => $language['name'],
                'name' => $language['name'],
                'slug' => Str::slug($language['name'], '_'),
                'meta_title' => $language['description'],
                'meta_description' => $language['description'],
                'meta_keywords' => $language['description'],
                'canonical' => $language['name'],
                'description' => $language['description'],
            ]);
        }

        return CustomResponse::resource(new ProductResource($product),'product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id)->firstOrFail();
        return CustomResponse::resource(new ProductResource($product),'product fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateproductRequest  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateproductRequest $request, $id)
    {
        $product = Product::find($id)->firstOrFail();
        $validated = $request->validated();
        if($file = $request->file('image_url')){
            $ImageName = time().$file->getClientOriginalName();
            Storage::disk('local')->delete('images/'.$product->image_url);
            Storage::disk('local')->putFileAs('images/',$file,$ImageName);
            $validated['image_url'] = $ImageName;
        }

        $brand = Brand::where('name',$validated['brand'])->first()->id;
        $category = Category::where('name',$validated['category'])->first()->id;

        $productData = $request->except(['brand','category']);
        $productData['brand_id'] = $brand;
        $productData['category'] = $category;

        $productData = [
            "width"         => $validated['width'],
            "height"        => $validated['height'],
            "depth"         =>  $validated['depth'],
            "brand_id"      => $brand,
            "category_id"   => $category,
            "image_url"     => $validated['image_url'],
            "user_id"       =>  Auth()->id(),
        ];

        $this->productRepository->update($product,$productData);

        $product_id = $product->id;

        $data = $request->data;
        foreach ($data as $language) {
            $languageToUpdate = LanguageProduct::where([
                'product_id' => $product_id,
                'language_id' => $language['language_id'],
            ]);
            $languageUpdate = [
                'name' => $language['name'],
                'slug' => Str::slug($language['name'], '_'),
                'meta_title' => $language['description'],
                'meta_description' => $language['description'],
                'meta_keywords' => $language['description'],
                'canonical' => $language['name'],
                'description' => $language['description'],
            ];
            $languageToUpdate->update($languageUpdate);
        }

        return CustomResponse::resource(new productResource($product),'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return CustomResponse::resource($this->productRepository->delete($id),'product deleted successfully');
    }

}

