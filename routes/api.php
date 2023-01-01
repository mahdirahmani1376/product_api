<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VerifyController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middlewear'=>'guest'], function(){
    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
});
##################################################email_verification###################################################
Route::group(['middlewear'=>'auth'],function(){
    Route::get('/email/verify',[VerifyController::class,'notice']);
    Route::get('/email/verify/{id}/{hash}',[VerifyController::class,'verify']);
    Route::post('/email/verification-notification',[VerifyController::class,'resend'])->middleware(['throttle:6,1']);
});
##################################################password_reset###################################################
Route::get('/forgot-password',[PasswordResetController::class,'passwordResetRequest']);
Route::post('/forgot-password',[PasswordResetController::class,'sendPasswordResetLink']);
Route::get('/reset-password/{token}', [PasswordResetController::class,'passwordResetForm']);
Route::post('/reset-password',[PasswordResetController::class,'resetPassword']);
##################################################product_crud#######################################################
Route::group(['prefix' => 'product'],function(){
Route::get('/',[ProductController::class,'index'])->middleware(['can:update,product','can:products_view']);
Route::get('/{product}',[ProductController::class,'show'])->middleware(['can:update,product','can:products_view']);
Route::post('/',[ProductController::class,'store'])->middleware(['can:update,product','can:products_store']);
Route::patch('/{product}',[ProductController::class,'update'])->middleware(['can:update,product','can:products_update']);
Route::delete('/{product}',[ProductController::class,'destroy'])->middleware(['can:delete,product','can:products_destroy']);
});
##################################################category_crud#######################################################
Route::group(['prefix' => 'category'],function(){
    Route::get('/',[CategoryController::class,'index'])->middleware(['can:category_view']);
    Route::get('/{category}',[CategoryController::class,'show'])->middleware(['can:category_view']);
    Route::post('/',[CategoryController::class,'store'])->middleware(['can:category_store']);
    Route::patch('/{category}',[CategoryController::class,'update'])->middleware(['can:category_update']);
    Route::delete('/{category}',[CategoryController::class,'destroy'])->middleware(['can:category_destroy']);
});
##################################################brand_crud#######################################################
Route::group(['prefix' => 'brand'],function(){
    Route::get('/',[brandController::class,'index'])->middleware(['can:brand_view']);
    Route::get('/{brand}',[brandController::class,'show'])->middleware(['can:brand_view']);
    Route::post('/',[brandController::class,'store'])->middleware(['can:brand_view']);
    Route::patch('/{brand}',[brandController::class,'update'])->middleware(['can:brand_view']);
    Route::delete('/{brand}',[brandController::class,'destroy'])->middleware(['can:brand_view']);
});
##################################################role_crud#######################################################
Route::group(['prefix' => 'role'],function(){
    Route::get('/',[RoleController::class,'index'])->middleware(['can:permissions_view']);
    Route::get('/{role}',[RoleController::class,'show'])->middleware(['can:permissions_view']);
    Route::post('/',[RoleController::class,'store'])->middleware(['can:permissions_store']);
    Route::patch('/{role}',[RoleController::class,'update'])->middleware(['can:permissions_update']);
    Route::delete('/{role}',[RoleController::class,'destroy'])->middleware(['can:permissions_destroy']);
    Route::post('/role_permission_attach',[RoleController::class,'attach'])->middleware(['can:permissions_attach_detach']);
    Route::post('/role_permission_detach',[RoleController::class,'detach'])->middleware(['can:permissions_attach_detach']);
});



