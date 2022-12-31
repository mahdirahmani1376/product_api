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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

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
##################################################email_verification###################################################
Route::group(['middleware' => ['role:Super Admin|admin|writer'],'prefix' => 'product'],function(){
Route::get('/',[ProductController::class,'index']);
Route::get('/{product}',[ProductController::class,'show']);
Route::post('/',[ProductController::class,'store']);
Route::patch('/{product}',[ProductController::class,'update'])->middleware('can:update,product');
Route::delete('/{product}',[ProductController::class,'destroy'])->middleware('can:delete,product');
});

Route::group(['middleware' => ['role:Super Admin|admin']],function(){
    Route::group(['prefix' => 'category'],function(){
        Route::get('/',[CategoryController::class,'index']);
        Route::get('/{category}',[CategoryController::class,'show']);
        Route::post('/',[CategoryController::class,'store']);
        Route::patch('/{category}',[CategoryController::class,'update']);
        Route::delete('/{category}',[CategoryController::class,'destroy']);
    });

    Route::group(['prefix' => 'brand'],function(){
        Route::get('/',[brandController::class,'index']);
        Route::get('/{brand}',[brandController::class,'show']);
        Route::post('/',[brandController::class,'store']);
        Route::patch('/{brand}',[brandController::class,'update']);
        Route::delete('/{brand}',[brandController::class,'destroy']);
    });
});

Route::group(['prefix' => 'role'],function(){
    Route::get('/',[RoleController::class,'index'])->middleware(['can:permissions_view']);
    Route::get('/{role}',[RoleController::class,'show'])->middleware(['can:permissions_view']);
    Route::post('/',[RoleController::class,'store'])->middleware(['can:permissions_store']);
    Route::patch('/{role}',[RoleController::class,'update'])->middleware(['can:permissions_update']);
    Route::delete('/{role}',[RoleController::class,'destroy'])->middleware(['can:permissions_destroy']);
    Route::post('/role_permission_attach',[RoleController::class,'attach'])->middleware(['can:permissions_attach_detach']);
    Route::post('/role_permission_detach',[RoleController::class,'detach'])->middleware(['can:permissions_attach_detach']);
});



