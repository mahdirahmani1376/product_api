<?php

namespace App\Repositories;


use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Language;
use App\Models\LanguageProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductRepository implements ProductInterface{

    public function index(){
        $products = Product::paginate(10);
        return ProductResource::collection($products);
    }

    public function store($request){
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

        return new ProductResource($product);
    }

    public function show($product){
        return new ProductResource($product);
    }

    public function update($request,$product){
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

        return new ProductResource($product);
    }

    public function destroy($product){
        $product->delete();
        return new ProductResource($product);
    }

    public function storeProduct(array $request)
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
