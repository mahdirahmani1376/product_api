<?php

namespace App\Http\Controllers;

use App\Models\LanguageProduct;
use App\Http\Requests\StoreLanguageProductRequest;
use App\Http\Requests\UpdateLanguageProductRequest;

class LanguageProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreLanguageProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLanguageProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LanguageProduct  $languageProduct
     * @return \Illuminate\Http\Response
     */
    public function show(LanguageProduct $languageProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LanguageProduct  $languageProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(LanguageProduct $languageProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLanguageProductRequest  $request
     * @param  \App\Models\LanguageProduct  $languageProduct
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLanguageProductRequest $request, LanguageProduct $languageProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LanguageProduct  $languageProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(LanguageProduct $languageProduct)
    {
        //
    }
}
