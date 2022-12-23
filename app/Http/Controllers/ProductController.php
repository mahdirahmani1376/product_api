<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\LanguageProduct;
use App\Models\product;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use App\Utilities\CustomResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function __construct(){
        $this->authorizeResource(Product::class,'product');
    }


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
            $ImageName = $file->getClientOriginalName();
            $file->move('images',$ImageName);
            $validated['image_url'] = $ImageName;
        }

        $product =$this->storeProduct($validated);
        $product_id = $product->id;

        $data = $request->data;
        foreach ($data as $language){
                LanguageProduct::create([
                    'language_id'          =>$language['language_id'],
                    'product_id'           =>$product_id,
                    'iso_code'    => Language::find($language['language_id'])->iso_code,
                    'model'                => $language['name'],
                    'name'                 => $language['name'],
                    'slug'                 => Str::slug($language['name'],'_'),
                    'meta_title'           => $language['description'],
                    'meta_description'     => $language['description'],
                    'meta_keywords'        => $language['description'],
                    'canonical'            => $language['name'],
                    'description'          => $language['description'],
                ]);
        }

        return CustomResponse::resource($product,'product created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(product $product)
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
    public function update(UpdateproductRequest $request, product $product)
    {
        $validated = $request->validated();

        if($file = $request->file('image_url')){
            $ImageName = $file->getClientOriginalName();
            $file->move('images',$ImageName);
            $validated['image_url'] = $ImageName;
        }

        $product->update($validated);

        return CustomResponse::resource($product,'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(product $product)
    {
        $product->delete();
        return CustomResponse::resource($product,'product deleted successfully');
    }


    private function storeProduct(array $request)
    {
        $product = Product::create([
            "brand"             =>$request['brand'],
            "category"          =>'test',
            "default_colors"    =>'test',
            "width"             =>$request['width'],
            "height"            =>$request['height'],
            "depth"             =>$request['depth'],
            "image_url"         =>$request['image_url'],
        ]);
        return $product;
    }
}
