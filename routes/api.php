<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
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

Route::get('/email/verify',[VerifyController::class,'notice'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}',[VerifyController::class,'verify'])->middleware(['auth'])->name('verification.verify');
Route::post('/email/verification-notification',[VerifyController::class,'resend'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::group(['middleware' => ['role:admin|writer'],'prefix' => 'product'],function(){
    Route::get('/',[ProductController::class,'index']);
    Route::get('/{product}',[ProductController::class,'show']);
    Route::post('/',[ProductController::class,'store']);
    Route::patch('/{product}',[ProductController::class,'update'])->middleware('can:update,product');
    Route::delete('/{product}',[ProductController::class,'destroy'])->middleware('can:delete,product');
});

Route::group(['middleware' => ['role:admin']],function(){
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





