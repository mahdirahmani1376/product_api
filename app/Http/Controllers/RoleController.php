<?php

namespace App\Http\Controllers;

use App\Utilities\CustomResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return CustomResponse::resource(Role::all(),'roles fetched successfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['name'=>'required']);
        $role = Role::create($validated);
        return CustomResponse::resource($role,'roles created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Role $role)
    {
        return CustomResponse::resource($role,'roles created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Role $role)
    {
        $role->update($role);
        return CustomResponse::resource($role,'roles updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return CustomResponse::resource($role,'roles deleted successfully');
    }

    public function attach(Request $request){
        $validated = $request->validate([
            'permission' => 'required|string|exists:Permissions,name',
            'role' => 'required|string|exists:Roles,name',
        ]);

        $role = Role::where('name',$validated['role'])->first();
        $permission = $role->givePermissionTo($validated['permission']);

        return CustomResponse::resource($permission,'permission attached successfully');
    }

    public function detach(Request $request,Role $role){

        $validated = $request->validate([
            'permission' => 'required|string|exists:Permissions,name',
            'role' => 'required|string|exists:Roles,name',
        ]);

        $role = Role::where('name',$validated['role'])->first();
        $permission = $role->revokePermissionTo($validated['permission']);

        return CustomResponse::resource($permission,'permission detached successfully');
    }
}
