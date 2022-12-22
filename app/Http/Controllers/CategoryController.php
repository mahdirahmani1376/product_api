<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Utilities\CustomResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return CustomResponse::resource(Category::paginate(10),'Category fetched susccesfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $Category = $request->validate([
            'name'=>'required|string'
        ]);
        Category::create($Category);

        return CustomResponse::resource(Category::paginate(10),'Category created susccesfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $Category)
    {
        return CustomResponse::resource($Category,'Category fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $Category)
    {
        $CategoryValidated = $request->validate([
            'name'=>'required|string'
        ]);
        $Category->update($CategoryValidated);

        return CustomResponse::resource($Category,'Category updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $Category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $Category)
    {
        $Category->delete();

        return CustomResponse::resource($Category,'Category deleted successfully');
    }
}
