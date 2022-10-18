<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\product;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'success';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreproductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreproductRequest $request)
    {

        $product = Product::create(request()->all());
        $language_persian = Language::create([
        'language_iso_code'=>'fa',
        'model'=> request('name'),
        'name'=> request('name'),
        'slug'=> str_replace(" ","_",request('name')),
        'meta_title'=> request('description'),
        'meta_description'=> request('description'),
        'meta_keywords'=> request('description'),
        'canonical'=> request('name'),
        'description'=> request('description'),
        ]);

        $language_english = Language::create([
            'language_iso_code'=>'en',
            'model'=> request('name'),
            'name'=> request('name'),
            'slug'=> str_replace(" ","_",request('name')),
            'meta_title'=> request('description'),
            'meta_description'=> request('description'),
            'meta_keywords'=> request('description'),
            'canonical'=> request('name'),
            'description'=> request('description'),
        ]);

        $product->languages()->attach([$language_persian->id,$language_english->id]);

        return 'product created successfully';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateproductRequest $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }
}
