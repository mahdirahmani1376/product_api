<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Utilities\CustomResponse;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return CustomResponse::resource(Brand::paginate(10),'brand fetched susccesfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name'=>'required|string',
            'logo'=> 'nullable|file',
        ]);

        if($file = $request->file('logo')){
            $name = $file->getClientOriginalName();
            $file->move('images',$name);
            $validated['logo'] = $name;
        }

        $brand = Brand::create($validated);

        $data = new BrandResource($brand);
        return CustomResponse::resource($data,'brand created susccesfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Brand $brand)
    {
        return CustomResponse::resource($brand,'brand fetched successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name'=>'required|string',
            'logo'=>'nullable|file'
        ]);

        if($file = $request->file('logo')){
            $name = $file->getClientOriginalName();
            $file->move('images',$name);
            $validated['logo'] = $name;
        }

        $brand->update($validated);

        return CustomResponse::resource($brand,'brand updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return CustomResponse::resource($brand,'brand deleted successfully');
    }
}
