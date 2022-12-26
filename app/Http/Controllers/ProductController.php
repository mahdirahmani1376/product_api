<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\LanguageProduct;
use App\Models\Product;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use App\Utilities\CustomResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::paginate(10);

        return CustomResponse::resource($products,'product fetched successfully');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        //
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



        $product =$this->storeProduct($validated);

        $product_id = $product->id;

        $data = $request->data;
        foreach ($data as $language){
                LanguageProduct::create([
                    'language_id'           =>$language['language_id'],
                    'product_id'            =>$product_id,
                    'iso_code'              => Language::find($language['language_id'])->iso_code,
                    'model'                 => $language['name'],
                    'name'                  => $language['name'],
                    'slug'                  => Str::slug($language['name'],'_'),
                    'meta_title'            => $language['description'],
                    'meta_description'      => $language['description'],
                    'meta_keywords'         => $language['description'],
                    'canonical'             => $language['name'],
                    'description'           => $language['description'],
                ]);
        }

        return CustomResponse::resource($product,'product created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {

        return CustomResponse::resource($product,'product fetched successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(product $product)

    {
        //
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

        $product->update($productData);

        $product_id = $product->id;

        $data = $request->data;
        foreach ($data as $language){
            $languageToUpdate = LanguageProduct::where([
                'product_id' => $product_id,
                'language_id' => $language['language_id'],
            ]);
            $languageUpdate = [
//                'language_id'           =>$language['language_id'],
//                'product_id'            =>$product_id,
//                'iso_code'              => Language::find($language['language_id'])->iso_code,
                'name'                  => $language['name'],
                'slug'                  => Str::slug($language['name'],'_'),
                'meta_title'            => $language['description'],
                'meta_description'      => $language['description'],
                'meta_keywords'         => $language['description'],
                'canonical'             => $language['name'],
                'description'           => $language['description'],
            ];
            $languageToUpdate->update($languageUpdate);

        }

        return CustomResponse::resource($product,'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return CustomResponse::resource($product,'product deleted successfully');
    }


    private function storeProduct(array $request)
    {
        $brand = Brand::where('name',$request['brand'])->first()->id;
        $category = Category::where('name',$request['category'])->first()->id;
        $product = Product::create([
            "brand_id"              =>  $brand,
            "category_id"           =>  $category,
            "default_colors"        =>  'test',
            "width"                 =>  $request['width'],
            "height"                =>  $request['height'],
            "depth"                 =>  $request['depth'],
            "image_url"             =>  $request['image_url'],
            "user_id"               =>  Auth()->id(),
        ]);
        return $product;
    }
}

