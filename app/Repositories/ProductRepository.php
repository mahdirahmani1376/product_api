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

    public function paginate(){
        $products = Product::paginate(10);
        return $products;
    }

    public function create($validated, $brand, $category){
        $product = Product::create([
            "brand_id"              =>  $brand,
            "category_id"           =>  $category,
            "default_colors"        =>  'test',
            "width"                 =>  $validated['width'],
            "height"                =>  $validated['height'],
            "depth"                 =>  $validated['depth'],
            "image_url"             =>  $validated['image_url'],
            "user_id"               =>  Auth()->id(),
        ]);

        return $product;;
    }

    public function update($product, $productData){

        $product->update($productData);

        return $product;
    }

    public function delete($id){
        $product = Product::find($id);
        $product->delete();
        return $product;
    }


}
